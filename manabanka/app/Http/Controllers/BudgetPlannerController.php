<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Budget;
use Illuminate\Support\Facades\Auth;

class BudgetPlannerController extends Controller
{
    public function index()
    {
        return view('budget-planner.index');
    }

    public function calculate(Request $request)
    {
        $validated = $request->validate([
            'age' => 'required|integer|min:0',
            'income' => 'required|numeric|min:0',
            'dependents' => 'required|integer|min:0',
            'debt' => 'required|in:yes,no',
            'goal' => 'required|string',
        ]);

        $age = $validated['age'];
        $income = $validated['income'];
        $dependents = $validated['dependents'];
        $debt = $validated['debt'];
        $goal = $validated['goal'];
        
        // Collect and validate detailed expenses
        $detailedExpenses = [
            'housing' => $request->input('housing', 0),
            'utilities' => $request->input('utilities', 0),
            'transportation' => $request->input('transportation', 0),
            'groceries' => $request->input('groceries', 0),
            'dining_out' => $request->input('dining_out', 0),
            'shopping' => $request->input('shopping', 0),
            'entertainment' => $request->input('entertainment', 0),
            'subscriptions' => $request->input('subscriptions', 0),
            'personal_care' => $request->input('personal_care', 0),
            'loan_payments' => $request->input('loan_payments', 0),
            'insurance' => $request->input('insurance', 0),
            'miscellaneous' => $request->input('miscellaneous', 0),
        ];

        // Sum detailed expenses to get total fixed expenses
        $fixed_expenses = array_sum($detailedExpenses);

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

        // Adjust for dependents: +3% needs, -3% wants per dependent
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

        // Generate personalized advice
        $advice = [];
        if ($dependents > 0) {
            $advice[] = 'Consider increasing your emergency fund to cover your dependents.';
        }
        if ($debt === 'yes') {
            $advice[] = 'Prioritize paying off high-interest debt before increasing spending on wants.';
        }
        switch ($goal) {
            case 'retirement':
                $advice[] = 'Consider increasing your retirement savings as your income grows.';
                break;
            case 'house':
                $advice[] = 'Consider setting aside extra savings for a house down payment.';
                break;
            case 'debt':
                $advice[] = 'Make a plan to pay off your debts as quickly as possible.';
                break;
            case 'emergency':
                $advice[] = 'Aim to build an emergency fund covering 3-6 months of expenses.';
                break;
            default:
                $advice[] = 'Review your budget regularly to stay on track with your goals.';
        }

        // Save to database
        $budget = Budget::create([
            'user_id' => Auth::id(),
            'age' => $age,
            'income' => $income,
            'fixed_expenses' => $fixed_expenses,
            'wants' => $wants,
            'savings' => $savings,
            'other' => $other,
            'dependents' => $dependents,
            'debt' => $debt,
            'goal' => $goal,
            'detailed_expenses' => $detailedExpenses,
        ]);

        return view('budget-planner.result', [
            'age' => $age,
            'income' => $income,
            'fixed_expenses' => $fixed_expenses,
            'wants' => $wants,
            'savings' => $savings,
            'debt_repayment' => $debt_repayment,
            'other' => $other,
            'dependents' => $dependents,
            'debt' => $debt,
            'goal' => $goal,
            'advice' => $advice,
            'detailed_expenses' => $detailedExpenses,
        ]);
    }

    public function budgets()
    {
        $budgets = Budget::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();
        return view('budget-planner.budgets', compact('budgets'));
    }

    public function destroy(Budget $budget)
    {
        if ($budget->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        $budget->delete();
        return redirect()->route('budgets.index')->with('success', 'Budget plan deleted successfully.');
    }

    public function show(Budget $budget)
    {
        if ($budget->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Recalculate budget based on stored data to get all derived values for the chart
        $age = $budget->age;
        $income = $budget->income;
        $dependents = $budget->dependents;
        $debt = $budget->debt;
        $goal = $budget->goal;
        $fixed_expenses = $budget->fixed_expenses; // This is already summed up detailed expenses

        // Age-based budget percentages (duplicated from calculate method)
        if ($age < 25) {
            $needs_pct = 0.55; $wants_pct = 0.30; $savings_pct = 0.15;
        } elseif ($age < 40) {
            $needs_pct = 0.50; $wants_pct = 0.30; $savings_pct = 0.20;
        } elseif ($age < 60) {
            $needs_pct = 0.45; $wants_pct = 0.30; $savings_pct = 0.25;
        } else {
            $needs_pct = 0.60; $wants_pct = 0.25; $savings_pct = 0.15;
        }

        // Adjust for dependents: +3% needs, -3% wants per dependent
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

        // Generate personalized advice (can be copied from calculate or re-generated)
        $advice = [];
        if ($dependents > 0) {
            $advice[] = 'Consider increasing your emergency fund to cover your dependents.';
        }
        if ($debt === 'yes') {
            $advice[] = 'Prioritize paying off high-interest debt before increasing spending on wants.';
        }
        switch ($goal) {
            case 'retirement':
                $advice[] = 'Consider increasing your retirement savings as your income grows.';
                break;
            case 'house':
                $advice[] = 'Consider setting aside extra savings for a house down payment.';
                break;
            case 'debt':
                $advice[] = 'Make a plan to pay off your debts as quickly as possible.';
                break;
            case 'emergency':
                $advice[] = 'Aim to build an emergency fund covering 3-6 months of expenses.';
                break;
            default:
                $advice[] = 'Review your budget regularly to stay on track with your goals.';
        }

        return view('budget-planner.show', [
            'budget' => $budget,
            'age' => $age,
            'income' => $income,
            'fixed_expenses' => $fixed_expenses,
            'wants' => $wants,
            'savings' => $savings,
            'debt_repayment' => $debt_repayment,
            'other' => $other,
            'dependents' => $dependents,
            'debt' => $debt,
            'goal' => $goal,
            'advice' => $advice,
            'detailed_expenses' => $budget->detailed_expenses,
        ]);
    }

    public function edit(Budget $budget)
    {
        if ($budget->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        return view('budget-planner.edit', compact('budget'));
    }

    public function update(Request $request, Budget $budget)
    {
        if ($budget->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        $validated = $request->validate([
            'income' => 'required|numeric|min:0',
            'fixed_expenses' => 'required|numeric|min:0',
            'dependents' => 'nullable|integer|min:0',
            'debt' => 'nullable|in:yes,no',
            'goal' => 'nullable|string',
        ]);
        // Convert empty strings to null for debt and goal, but keep 0 for dependents
        $validated['debt'] = ($validated['debt'] === '') ? null : $validated['debt'];
        $validated['goal'] = ($validated['goal'] === '') ? null : $validated['goal'];
        $validated['dependents'] = ($request->has('dependents') && $validated['dependents'] !== '') ? (int)$validated['dependents'] : null;
        $budget->update($validated);
        \Log::info('Budget update request', $request->all());
        \Log::info('Budget update validated', $validated);
        return redirect()->route('budgets.show', $budget->id)->with('success', 'Budget plan updated successfully.');
    }
} 