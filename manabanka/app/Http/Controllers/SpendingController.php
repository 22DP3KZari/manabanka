<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Spending;
use App\Models\CategoryBudget;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class SpendingController extends Controller
{
    public function index(Request $request)
    {
        $period = $request->get('period', '1m'); // 1w, 1m, 6m, 1y
        $tab = $request->get('tab', 'spending'); // spending, income, cashflow, budget
        
        // Calculate date range based on period
        $endDate = Carbon::now();
        $startDate = match($period) {
            '1w' => $endDate->copy()->subWeek(),
            '1m' => $endDate->copy()->subMonth(),
            '6m' => $endDate->copy()->subMonths(6),
            '1y' => $endDate->copy()->subYear(),
            default => $endDate->copy()->subMonth(),
        };

        // Handle different tabs
        if ($tab === 'budget') {
            // Get current month's budgets
            $now = Carbon::now();
            $categoryBudgets = CategoryBudget::where('user_id', Auth::id())
                ->where('year', $now->year)
                ->where('month', $now->month)
                ->get();

            // Get actual spending for current month
            $spendings = Spending::where('user_id', Auth::id())
                ->whereYear('date', $now->year)
                ->whereMonth('date', $now->month)
                ->get();

            $spendingByCategory = $spendings->groupBy('category')->map(function ($items) {
                return [
                    'amount' => $items->sum('amount'),
                    'count' => $items->count(),
                ];
            });

            // Combine budgets with spending - key by category
            $categoryData = [];
            foreach ($categoryBudgets as $budget) {
                $spendingInfo = $spendingByCategory->get($budget->category, ['amount' => 0, 'count' => 0]);
                $actual = $spendingInfo['amount'];
                $percentage = $budget->monthly_budget > 0 ? ($actual / $budget->monthly_budget) * 100 : 0;
                
                $categoryData[$budget->category] = [
                    'total' => $actual,
                    'budget' => $budget->monthly_budget,
                    'remaining' => $budget->monthly_budget - $actual,
                    'percentage' => $percentage,
                    'count' => $spendingInfo['count'],
                    'status' => $percentage <= 80 ? 'on_track' : ($percentage <= 100 ? 'warning' : 'over_budget'),
                ];
            }

            // Sort by total descending
            uasort($categoryData, function($a, $b) {
                return $b['total'] <=> $a['total'];
            });

            $totalSpent = $spendings->sum('amount');
        } else {
            // Get spending data for the period
            $spendings = Spending::where('user_id', Auth::id())
                ->whereBetween('date', [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')])
                ->get();

            // Group by category
            $categoryData = $spendings->groupBy('category')->map(function ($items) {
                return [
                    'total' => $items->sum('amount'),
                    'count' => $items->count(),
                    'transactions' => $items->sortByDesc('date')
                ];
            })->sortByDesc('total');

            $totalSpent = $spendings->sum('amount');

            // Calculate percentages
            $categoryData = $categoryData->map(function ($data) use ($totalSpent) {
                $data['percentage'] = $totalSpent > 0 ? round(($data['total'] / $totalSpent) * 100) : 0;
                return $data;
            });
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

        return view('spending.index', compact(
            'spendings',
            'categoryData',
            'totalSpent',
            'startDate',
            'endDate',
            'period',
            'tab',
            'categoryColors'
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
