<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Budget;
use App\Models\CategoryBudget;
use Illuminate\Support\Facades\Auth;
use App\Models\Spending;
use Carbon\Carbon;

class BudgetPlannerController extends Controller
{
    public function index()
    {
        return view('budget-planner.index');
    }

    public function calculate(Request $request)
    {
        $validated = $request->validate([
            'income' => 'required|numeric|min:0',
            'name' => 'nullable|string|max:255',
        ]);

        $income = $validated['income'];
        $name = $validated['name'] ?? 'Budget ' . Carbon::now()->format('M Y');
        $now = Carbon::now();
        $year = $now->year;
        $month = $now->month;
        
        // Collect category budgets from request
        $categories = [
            'housing', 'utilities', 'transportation', 'groceries',
            'dining_out', 'shopping', 'entertainment', 'subscriptions',
            'personal_care', 'loan_payments', 'insurance', 'miscellaneous'
        ];

        $categoryBudgets = [];
        $totalBudget = 0;

        // First create the budget
        $budget = Budget::create([
            'user_id' => Auth::id(),
            'name' => $name,
            'income' => $income,
            'fixed_expenses' => 0, // Will update after calculating
            'wants' => 0,
            'savings' => 0,
            'other' => 0,
            'detailed_expenses' => [],
        ]);

        foreach ($categories as $category) {
            $budgetAmount = $request->input($category, 0);
            if ($budgetAmount > 0) {
                // Create or update category budget linked to this budget
                CategoryBudget::updateOrCreate(
                    [
                        'budget_id' => $budget->id,
                        'category' => $category,
                        'year' => $year,
                        'month' => $month,
                    ],
                    [
                        'user_id' => Auth::id(),
                        'monthly_budget' => $budgetAmount,
                    ]
                );
                
                $categoryBudgets[$category] = $budgetAmount;
                $totalBudget += $budgetAmount;
            }
        }

        // Calculate remaining amount (for savings/other)
        $remaining = $income - $totalBudget;

        // Update budget with calculated values
        $budget->update([
            'fixed_expenses' => $totalBudget,
            'savings' => max(0, $remaining * 0.7), // 70% of remaining to savings
            'other' => max(0, $remaining * 0.3), // 30% of remaining as buffer
            'detailed_expenses' => $categoryBudgets,
        ]);

        return redirect()->route('budgets.index')
            ->with('success', __('common.budget_created_successfully'));
    }

    public function budgets(Request $request)
    {
        // Get all budgets for the user
        $budgets = Budget::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        $now = Carbon::now();
        $year = $now->year;
        $month = $now->month;

        // Get selected budget ID from query parameter, default to latest
        $selectedBudgetId = $request->get('budget_id');
        if ($selectedBudgetId) {
            $selectedBudget = $budgets->firstWhere('id', $selectedBudgetId);
            if (!$selectedBudget || $selectedBudget->user_id !== Auth::id()) {
                // Invalid budget ID, use latest
                $selectedBudget = $budgets->first();
            }
        } else {
            // Default to latest budget
            $selectedBudget = $budgets->first();
        }

        // Get category budgets for the selected budget
        // Try multiple approaches to find category budgets
        $categoryBudgets = collect();
        
        if ($selectedBudget) {
            // Approach 1: Use relationship to get category budgets
            $categoryBudgets = $selectedBudget->categoryBudgets()
                ->orderBy('year', 'desc')
                ->orderBy('month', 'desc')
                ->get();
            
            // Approach 2: If no results via relationship, try direct query by budget_id
            if ($categoryBudgets->isEmpty()) {
                $categoryBudgets = CategoryBudget::where('user_id', Auth::id())
                    ->where('budget_id', $selectedBudget->id)
                    ->orderBy('year', 'desc')
                    ->orderBy('month', 'desc')
                    ->get();
            }
            
            // Approach 3: If still empty, try to use detailed_expenses from the budget itself
            // This is a fallback for budgets that don't have CategoryBudget records
            if ($categoryBudgets->isEmpty() && $selectedBudget->detailed_expenses) {
                $detailedExpenses = $selectedBudget->detailed_expenses;
                $budgetYear = $selectedBudget->created_at->year;
                $budgetMonth = $selectedBudget->created_at->month;
                
                // Create CategoryBudget-like data from detailed_expenses
                foreach ($detailedExpenses as $category => $amount) {
                    if ($amount > 0) {
                        $categoryBudgets->push((object)[
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
            
            // Approach 4: If still empty, get ANY category budgets for current month
            // This is a last resort fallback
            if ($categoryBudgets->isEmpty()) {
                $categoryBudgets = CategoryBudget::where('user_id', Auth::id())
                    ->where('year', $year)
                    ->where('month', $month)
                    ->orderBy('created_at', 'desc')
                    ->get();
            }
            
            // Update year/month for display if we found budgets for a different period
            if ($categoryBudgets->isNotEmpty() && $categoryBudgets->first() instanceof CategoryBudget) {
                $firstBudget = $categoryBudgets->first();
                $year = $firstBudget->year;
                $month = $firstBudget->month;
            }
        }

        // Get actual spending for the same month/year as the category budgets
        // Filter by budget_id to show only spending for the selected budget
        $spendings = Spending::where('user_id', Auth::id())
            ->where('budget_id', $selectedBudget ? $selectedBudget->id : null)
            ->whereYear('date', $year)
            ->whereMonth('date', $month)
            ->get();

        // Calculate spending by category
        $spendingByCategory = $spendings->groupBy('category')->map(function ($items) {
            return $items->sum('amount');
        });

        // Combine budgets with actual spending
        // Handle both CategoryBudget models and plain objects
        $budgetData = $categoryBudgets->map(function ($categoryBudget) use ($spendingByCategory, $selectedBudget) {
            // Handle both model instances and plain objects
            $category = is_object($categoryBudget) ? $categoryBudget->category : null;
            $monthlyBudget = is_object($categoryBudget) ? (float)$categoryBudget->monthly_budget : 0;
            $budgetId = is_object($categoryBudget) ? ($categoryBudget->budget_id ?? null) : null;
            
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
                'budget_id' => $budgetId ?? ($selectedBudget ? $selectedBudget->id : null),
            ];
        })->filter(); // Remove any null entries

        return view('budget-planner.budgets', compact('budgets', 'budgetData', 'selectedBudget', 'year', 'month'));
    }

    public function destroy(Budget $budget)
    {
        if ($budget->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        $budget->delete();
        return redirect()->route('budgets.index')->with('success', 'Budget plan deleted successfully.');
    }

    public function edit(Budget $budget)
    {
        if ($budget->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Get spending data for the current month
        $currentMonth = now()->format('Y-m');
        $spending = Spending::where('user_id', Auth::id())
            ->whereYear('date', now()->year)
            ->whereMonth('date', now()->month)
            ->get();

        // Calculate total spending by category
        $totalSpending = [
            'housing' => $spending->where('category', 'housing')->sum('amount'),
            'utilities' => $spending->where('category', 'utilities')->sum('amount'),
            'transportation' => $spending->where('category', 'transportation')->sum('amount'),
            'groceries' => $spending->where('category', 'groceries')->sum('amount'),
            'insurance' => $spending->where('category', 'insurance')->sum('amount'),
            'loan_payments' => $spending->where('category', 'loan_payments')->sum('amount'),
            'personal_care' => $spending->where('category', 'personal_care')->sum('amount'),
            'dining_out' => $spending->where('category', 'dining_out')->sum('amount'),
            'shopping' => $spending->where('category', 'shopping')->sum('amount'),
            'entertainment' => $spending->where('category', 'entertainment')->sum('amount'),
            'subscriptions' => $spending->where('category', 'subscriptions')->sum('amount'),
            'miscellaneous' => $spending->where('category', 'miscellaneous')->sum('amount'),
        ];

        return view('budgets.edit', compact('budget', 'totalSpending'));
    }

    public function update(Request $request, Budget $budget)
    {
        if ($budget->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'age' => 'required|integer|min:0',
            'income' => 'required|numeric|min:0',
            'dependents' => 'required|integer|min:0',
            'debt' => 'required|in:yes,no',
            'goal' => 'required|string',
            'housing' => 'required|numeric|min:0',
            'utilities' => 'required|numeric|min:0',
            'transportation' => 'required|numeric|min:0',
            'groceries' => 'required|numeric|min:0',
            'insurance' => 'required|numeric|min:0',
            'loan_payments' => 'required|numeric|min:0',
            'personal_care' => 'required|numeric|min:0',
            'dining_out' => 'required|numeric|min:0',
            'shopping' => 'required|numeric|min:0',
            'entertainment' => 'required|numeric|min:0',
            'subscriptions' => 'required|numeric|min:0',
            'miscellaneous' => 'required|numeric|min:0',
        ]);

        // Collect detailed expenses
        $detailedExpenses = [
            'housing' => $validated['housing'],
            'utilities' => $validated['utilities'],
            'transportation' => $validated['transportation'],
            'groceries' => $validated['groceries'],
            'insurance' => $validated['insurance'],
            'loan_payments' => $validated['loan_payments'],
            'personal_care' => $validated['personal_care'],
            'dining_out' => $validated['dining_out'],
            'shopping' => $validated['shopping'],
            'entertainment' => $validated['entertainment'],
            'subscriptions' => $validated['subscriptions'],
            'miscellaneous' => $validated['miscellaneous'],
        ];

        // Calculate total fixed expenses
        $fixed_expenses = array_sum($detailedExpenses);

        // Update the budget with new values
        $budget->update([
            'age' => $validated['age'],
            'income' => $validated['income'],
            'fixed_expenses' => $fixed_expenses,
            'dependents' => $validated['dependents'],
            'debt' => $validated['debt'],
            'goal' => $validated['goal'],
            'detailed_expenses' => $detailedExpenses,
        ]);

        // Recalculate the budget distribution
        $age = $validated['age'];
        $income = $validated['income'];
        $dependents = $validated['dependents'];
        $debt = $validated['debt'];
        $goal = $validated['goal'];

        // Age-based budget percentages
        if ($age < 25) {
            $needs_pct = 0.55; $wants_pct = 0.30; $savings_pct = 0.15;
        } elseif ($age < 40) {
            $needs_pct = 0.50; $wants_pct = 0.30; $savings_pct = 0.20;
        } elseif ($age < 60) {
            $needs_pct = 0.45; $wants_pct = 0.30; $savings_pct = 0.25;
        } else {
            $needs_pct = 0.60; $wants_pct = 0.25; $savings_pct = 0.15;
        }

        // Adjust for dependents
        $needs_pct += 0.03 * $dependents;
        $wants_pct -= 0.03 * $dependents;

        // Debt repayment logic
        $debt_repayment_pct = 0;
        if ($debt === 'yes') {
            $debt_repayment_pct += 0.10;
            $wants_pct -= 0.10;
        }

        // Adjust for financial goal
        if ($goal === 'emergency') {
            $savings_pct += 0.05;
            $wants_pct -= 0.05;
        } elseif ($goal === 'debt') {
            $debt_repayment_pct += 0.05;
            $wants_pct -= 0.05;
        } elseif ($goal === 'retirement' && $age > 40) {
            $savings_pct += 0.05;
            $wants_pct -= 0.05;
        }

        // Ensure no category is negative
        if ($wants_pct < 0) {
            $needs_pct += $wants_pct;
            $wants_pct = 0;
        }
        if ($needs_pct < 0) $needs_pct = 0;
        if ($savings_pct < 0) $savings_pct = 0;
        if ($debt_repayment_pct < 0) $debt_repayment_pct = 0;

        // Calculate amounts
        $needs = $fixed_expenses;
        $remaining = $income - $needs;
        $other = $remaining * 0.05; // Always reserve 5% for buffer
        $distributable = $remaining - $other;
        $total_pct = $wants_pct + $savings_pct + $debt_repayment_pct;

        $wants = $total_pct > 0 ? $distributable * $wants_pct / $total_pct : 0;
        $savings = $total_pct > 0 ? $distributable * $savings_pct / $total_pct : 0;
        $debt_repayment = $total_pct > 0 ? $distributable * $debt_repayment_pct / $total_pct : 0;

        // Update the calculated values
        $budget->update([
            'wants' => $wants,
            'savings' => $savings,
            'other' => $other,
        ]);

        return redirect()->route('budgets.index')
            ->with('success', 'Budget plan updated successfully.');
    }

    public function updateSpending(Request $request)
    {
        $validated = $request->validate([
            'budget_id' => 'required|exists:budgets,id',
            'category' => 'required|string|in:housing,utilities,transportation,groceries,dining_out,shopping,entertainment,subscriptions,personal_care,loan_payments,insurance,miscellaneous',
            'amount' => 'required|numeric|min:0',
        ]);

        $budget = Budget::findOrFail($validated['budget_id']);
        
        // Ensure user owns this budget
        if ($budget->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $now = Carbon::now();
        $year = $now->year;
        $month = $now->month;

        // Get current spending for this category in this month for this specific budget
        $currentSpending = Spending::where('user_id', Auth::id())
            ->where('budget_id', $validated['budget_id'])
            ->where('category', $validated['category'])
            ->whereYear('date', $year)
            ->whereMonth('date', $month)
            ->sum('amount');

        // The amount from the form is the ADDITIONAL amount to add, not the total
        $additionalAmount = $validated['amount'];
        $targetAmount = $currentSpending + $additionalAmount;
        $difference = $targetAmount - $currentSpending;

        if (abs($difference) < 0.01) {
            // No change needed
            return redirect()->route('budgets.index')
                ->with('success', __('common.spending_updated_successfully'));
        }

        if ($difference > 0) {
            // Need to add spending - link it to the budget
            Spending::create([
                'user_id' => Auth::id(),
                'budget_id' => $validated['budget_id'],
                'category' => $validated['category'],
                'amount' => $difference,
                'date' => Carbon::now(),
                'description' => __('common.manual_adjustment'),
            ]);
        } else {
            // Need to reduce spending - delete or reduce existing transactions
            // Only affect spending for this specific budget
            $spendings = Spending::where('user_id', Auth::id())
                ->where('budget_id', $validated['budget_id'])
                ->where('category', $validated['category'])
                ->whereYear('date', $year)
                ->whereMonth('date', $month)
                ->orderBy('date', 'desc')
                ->get();

            $remainingToRemove = abs($difference);
            
            foreach ($spendings as $spending) {
                if ($remainingToRemove <= 0) break;
                
                if ($spending->amount <= $remainingToRemove) {
                    $remainingToRemove -= $spending->amount;
                    $spending->delete();
                } else {
                    $spending->update(['amount' => $spending->amount - $remainingToRemove]);
                    $remainingToRemove = 0;
                }
            }
        }

        return redirect()->route('budgets.index')
            ->with('success', __('common.spending_updated_successfully'));
    }
} 