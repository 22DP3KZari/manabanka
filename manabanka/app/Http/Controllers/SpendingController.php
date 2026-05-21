<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use App\Models\CategoryBudget;
use App\Models\Spending;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class SpendingController extends Controller
{
    /** Max spending rows to render per category in the expandable list (keeps DOM small). */
    private const MAX_TRANSACTIONS_PER_CATEGORY = 45;

    /** Upper bound on rows read when filling per-category recent lists. */
    private const RECENT_SPENDING_FETCH_CAP = 700;

    // Core spending CRUD plus analytics data for charts and budget comparison.
    public function index(Request $request)
    {
        $period = $request->get('period', '1m'); // 1w, 1m, 6m, 1y
        $tab = $request->get('tab', 'spending'); // spending, income, cashflow, budget

        // Calculate date range based on period
        $endDate = Carbon::now();
        $startDate = match ($period) {
            '1w' => $endDate->copy()->subWeek(),
            '1m' => $endDate->copy()->subMonth(),
            '6m' => $endDate->copy()->subMonths(6),
            '1y' => $endDate->copy()->subYear(),
            default => $endDate->copy()->subMonth(),
        };

        $userId = Auth::id();
        $budgets = collect();
        $selectedBudget = null;
        $budgetMonthLabel = null;

        // Handle different tabs
        if ($tab === 'budget') {
            $budgets = Budget::where('user_id', $userId)->orderByDesc('created_at')->get();

            $requestedId = (int) $request->get('budget_id');
            if ($requestedId && $budgets->contains('id', $requestedId)) {
                session(['spending_selected_budget_id' => $requestedId]);
            }

            $sessionId = (int) session('spending_selected_budget_id');
            $selectedBudget = $budgets->firstWhere('id', $sessionId) ?? $budgets->first();

            $categoryData = [];
            $totalSpent = 0.0;

            if ($selectedBudget) {
                $periodAnchor = CategoryBudget::query()
                    ->where('budget_id', $selectedBudget->id)
                    ->orderByDesc('year')
                    ->orderByDesc('month')
                    ->first();

                $budgetYear = $periodAnchor?->year ?? $selectedBudget->created_at->year;
                $budgetMonth = $periodAnchor?->month ?? $selectedBudget->created_at->month;
                $monthCarbon = Carbon::create($budgetYear, $budgetMonth, 1)->locale(app()->getLocale());
                $monthName = mb_convert_case($monthCarbon->translatedFormat('F'), MB_CASE_TITLE, 'UTF-8');
                $budgetMonthLabel = $monthName.' '.$budgetYear;

                $categoryBudgets = CategoryBudget::where('user_id', $userId)
                    ->where('budget_id', $selectedBudget->id)
                    ->where('year', $budgetYear)
                    ->where('month', $budgetMonth)
                    ->get();

                $spendingByCategory = Spending::query()
                    ->where('user_id', $userId)
                    ->where('budget_id', $selectedBudget->id)
                    ->whereYear('date', $budgetYear)
                    ->whereMonth('date', $budgetMonth)
                    ->selectRaw('category, SUM(amount) as total_amount, COUNT(*) as cnt')
                    ->groupBy('category')
                    ->get()
                    ->keyBy('category')
                    ->map(fn ($row) => [
                        'amount' => (float) $row->total_amount,
                        'count' => (int) $row->cnt,
                    ]);

                foreach ($categoryBudgets as $categoryBudget) {
                    $spendingInfo = $spendingByCategory->get($categoryBudget->category, ['amount' => 0, 'count' => 0]);
                    $actual = $spendingInfo['amount'];
                    $percentage = $categoryBudget->monthly_budget > 0
                        ? ($actual / $categoryBudget->monthly_budget) * 100
                        : 0;

                    $categoryData[$categoryBudget->category] = [
                        'total' => $actual,
                        'budget' => $categoryBudget->monthly_budget,
                        'remaining' => $categoryBudget->monthly_budget - $actual,
                        'percentage' => $percentage,
                        'count' => $spendingInfo['count'],
                        'status' => $percentage <= 80 ? 'on_track' : ($percentage <= 100 ? 'warning' : 'over_budget'),
                    ];
                }

                uasort($categoryData, fn ($a, $b) => $b['total'] <=> $a['total']);

                $totalSpent = $spendingByCategory->sum(fn (array $row) => $row['amount']);
            }
        } else {
            $startStr = $startDate->format('Y-m-d');
            $endStr = $endDate->format('Y-m-d');

            // Totals per category in the database (fast path for chart + summary cards)
            $aggregates = Spending::query()
                ->where('user_id', $userId)
                ->whereBetween('date', [$startStr, $endStr])
                ->selectRaw('category, SUM(amount) as total_amount, COUNT(*) as cnt')
                ->groupBy('category')
                ->get();

            $totalSpent = (float) $aggregates->sum('total_amount');

            $categoryData = Collection::make();
            foreach ($aggregates->sortByDesc('total_amount') as $row) {
                $cat = $row->category;
                $catTotal = (float) $row->total_amount;
                $categoryData->put($cat, [
                    'total' => $catTotal,
                    'count' => (int) $row->cnt,
                    'percentage' => $totalSpent > 0 ? round(($catTotal / $totalSpent) * 100) : 0,
                    'transactions' => collect(),
                ]);
            }

            // Recent lines for the expandable lists only (capped per category)
            if ($categoryData->isNotEmpty()) {
                $recent = Spending::query()
                    ->where('user_id', $userId)
                    ->whereBetween('date', [$startStr, $endStr])
                    ->select(['id', 'category', 'amount', 'date', 'description'])
                    ->orderByDesc('date')
                    ->limit(self::RECENT_SPENDING_FETCH_CAP)
                    ->get();

                $perCat = [];
                foreach ($recent as $line) {
                    if (! $categoryData->has($line->category)) {
                        continue;
                    }
                    $n = $perCat[$line->category] ?? 0;
                    if ($n >= self::MAX_TRANSACTIONS_PER_CATEGORY) {
                        continue;
                    }
                    $categoryData[$line->category]['transactions']->push($line);
                    $perCat[$line->category] = $n + 1;
                }
            }
        }

        // Category colors for chart
        $categoryColors = [
            'dining_out' => '#FF6B6B',      // Red/Orange
            'transportation' => '#9B59B6',  // Purple
            'groceries' => '#2ECC71',        // Green
            'shopping' => '#E74C3C',         // Red
            'entertainment' => '#F39C12',    // Orange
            'housing' => '#3498DB',          // Blue
            'utilities' => '#1ABC9C',        // Teal
            'insurance' => '#95A5A6',        // Gray
            'loan_payments' => '#34495E',    // Dark Gray
            'personal_care' => '#E91E63',    // Pink
            'subscriptions' => '#673AB7',     // Deep Purple
            'miscellaneous' => '#FF9800',    // Orange
        ];

        // Chart.js only needs per-category totals — avoid embedding full transaction lists in the page JSON.
        $chartCategoryData = [];
        $rowsForChart = $categoryData instanceof Collection ? $categoryData->all() : $categoryData;
        foreach ($rowsForChart as $cat => $row) {
            $chartCategoryData[$cat] = ['total' => $row['total']];
        }

        return view('spending.index', compact(
            'categoryData',
            'chartCategoryData',
            'totalSpent',
            'startDate',
            'endDate',
            'period',
            'tab',
            'categoryColors',
            'budgets',
            'selectedBudget',
            'budgetMonthLabel'
        ));
    }

    public function create()
    {
        return view('spending.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category' => 'required|string|in:housing,utilities,transportation,groceries,dining_out,shopping,entertainment,subscriptions,personal_care,loan_payments,insurance,miscellaneous',
            'amount' => 'required|numeric|min:0.01',
            'date' => 'required|date',
            'description' => 'nullable|string|max:255',
        ]);

        Spending::create([
            'user_id' => Auth::id(),
            'category' => $validated['category'],
            'amount' => $validated['amount'],
            'date' => $validated['date'],
            'description' => $validated['description'] ?? null,
        ]);

        return redirect()->route('spending.index')
            ->with('success', __('common.spending_added_successfully'));
    }

    public function edit(Spending $spending)
    {
        if ($spending->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('spending.edit', compact('spending'));
    }

    public function update(Request $request, Spending $spending)
    {
        if ($spending->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'category' => 'required|string|in:housing,utilities,transportation,groceries,dining_out,shopping,entertainment,subscriptions,personal_care,loan_payments,insurance,miscellaneous',
            'amount' => 'required|numeric|min:0.01',
            'date' => 'required|date',
            'description' => 'nullable|string|max:255',
        ]);

        $spending->update([
            'category' => $validated['category'],
            'amount' => $validated['amount'],
            'date' => $validated['date'],
            'description' => $validated['description'] ?? null,
        ]);

        return redirect()->route('spending.index')
            ->with('success', __('common.spending_updated_successfully'));
    }

    public function destroy(Spending $spending)
    {
        if ($spending->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $spending->delete();

        return redirect()->route('spending.index')
            ->with('success', __('common.spending_deleted_successfully'));
    }
}
