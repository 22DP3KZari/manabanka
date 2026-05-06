<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use App\Models\CategoryBudget;
use App\Models\Goal;
use App\Models\Spending;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    // Builds the signed-in user's dashboard cards and progress widgets.
    /**
     * Show the user dashboard with real budget health and goals.
     */
    public function index()
    {
        $budgetHealth = $this->getBudgetHealthForDashboard();
        $goals = Goal::where('user_id', Auth::id())
            ->whereIn('type', [Goal::TYPE_EMERGENCY_FUND, Goal::TYPE_FIRST_ETF_BUY])
            ->get()
            ->keyBy('type');

        return view('dashboard', [
            'budgetHealth' => $budgetHealth,
            'emergencyFundGoal' => $goals->get(Goal::TYPE_EMERGENCY_FUND),
            'firstEtfGoal' => $goals->get(Goal::TYPE_FIRST_ETF_BUY),
        ]);
    }

    /**
     * Load the current user's latest budget and compute per-category health (same logic as BudgetPlannerController).
     * Returns up to 5 categories with label, status, remaining, and percentage for the dashboard card.
     */
    private function getBudgetHealthForDashboard(): array
    {
        // Always anchor dashboard health to the user's latest budget snapshot.
        $selectedBudget = Budget::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->first();

        if (!$selectedBudget) {
            return [];
        }

        $year = Carbon::now()->year;
        $month = Carbon::now()->month;
        $categoryBudgets = $selectedBudget->categoryBudgets()
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->get();

        if ($categoryBudgets->isEmpty()) {
            $categoryBudgets = CategoryBudget::where('user_id', Auth::id())
                ->where('budget_id', $selectedBudget->id)
                ->orderBy('year', 'desc')
                ->orderBy('month', 'desc')
                ->get();
        }

        if ($categoryBudgets->isEmpty() && $selectedBudget->detailed_expenses) {
            $budgetYear = $selectedBudget->created_at->year;
            $budgetMonth = $selectedBudget->created_at->month;
            foreach ((array) $selectedBudget->detailed_expenses as $category => $amount) {
                if ($amount > 0) {
                    $categoryBudgets->push((object) [
                        'category' => $category,
                        'monthly_budget' => $amount,
                        'year' => $budgetYear,
                        'month' => $budgetMonth,
                        'budget_id' => $selectedBudget->id,
                    ]);
                }
            }
            if ($categoryBudgets->isNotEmpty()) {
                $year = $budgetYear;
                $month = $budgetMonth;
            }
        }

        if ($categoryBudgets->isEmpty()) {
            $categoryBudgets = CategoryBudget::where('user_id', Auth::id())
                ->where('year', $year)
                ->where('month', $month)
                ->orderBy('created_at', 'desc')
                ->get();
        }

        if ($categoryBudgets->isNotEmpty() && $categoryBudgets->first() instanceof CategoryBudget) {
            $first = $categoryBudgets->first();
            $year = $first->year;
            $month = $first->month;
        }

        $spendings = Spending::where('user_id', Auth::id())
            ->where('budget_id', $selectedBudget->id)
            ->whereYear('date', $year)
            ->whereMonth('date', $month)
            ->get();

        $spendingByCategory = $spendings->groupBy('category')->map(fn ($items) => $items->sum('amount'));

        $budgetData = $categoryBudgets->map(function ($cb) use ($spendingByCategory, $selectedBudget) {
            $category = is_object($cb) ? $cb->category : null;
            $monthlyBudget = is_object($cb) ? (float) $cb->monthly_budget : 0;
            if (!$category) {
                return null;
            }
            $actual = $spendingByCategory->get($category, 0);
            $percentage = $monthlyBudget > 0 ? ($actual / $monthlyBudget) * 100 : 0;
            return [
                'category' => $category,
                'budget' => $monthlyBudget,
                'actual' => $actual,
                'remaining' => $monthlyBudget - $actual,
                'percentage' => $percentage,
                'status' => $percentage <= 80 ? 'on_track' : ($percentage <= 100 ? 'warning' : 'over_budget'),
            ];
        })->filter()->values();

        $categoryLabelKey = 'common.category_';
        return $budgetData->take(5)->map(function ($row) use ($categoryLabelKey) {
            return [
                'label' => __($categoryLabelKey . $row['category']),
                'status' => $row['status'],
                'remaining' => $row['remaining'],
                'percentage' => (int) round($row['percentage']),
            ];
        })->all();
    }
}
