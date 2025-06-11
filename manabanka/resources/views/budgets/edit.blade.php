@extends('layouts.app')

@section('title', 'Budget Planner - manaBanka')

@section('content')
<div class="max-w-2xl mx-auto py-10">
    <h1 class="text-3xl font-bold mb-6">Budget Planner</h1>
    <a href="{{ route('budgets.index') }}" class="mb-6 inline-block bg-yellow-600 text-white px-6 py-2 rounded hover:bg-yellow-700">My Budgets</a>
    <form action="{{ route('budgets.update', $budget) }}" method="POST" class="space-y-4 bg-white p-6 rounded-lg shadow" id="budgetForm">
        @csrf
        @method('PUT')
        <div>
            <label for="age" class="block text-sm font-medium text-gray-700">Age</label>
            <input type="number" name="age" id="age" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required min="0" placeholder="Enter your age" value="{{ $budget->age }}">
        </div>
        <div>
            <label for="income" class="block text-sm font-medium text-gray-700">Monthly Income (€)</label>
            <input type="number" step="0.01" name="income" id="income" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required min="0" placeholder="Enter your monthly income" value="{{ $budget->income }}">
        </div>

        <!-- Total Expenses Display -->
        <div id="totalExpensesDisplay" class="hidden mt-4 p-4 bg-yellow-50 rounded-lg">
            <div class="flex justify-between items-center">
                <span class="text-sm font-medium text-yellow-800">Total Expenses:</span>
                <span id="totalExpenses" class="text-lg font-bold text-yellow-800">€0.00</span>
            </div>
            <div class="flex justify-between items-center mt-2">
                <span class="text-sm font-medium text-yellow-800">Remaining Income:</span>
                <span id="remainingIncome" class="text-lg font-bold text-yellow-800">€0.00</span>
            </div>
        </div>

        <!-- Needs Section -->
        <div class="mt-8 p-4 bg-blue-50 rounded-lg">
            <h2 class="text-xl font-semibold mb-4 text-blue-800">Essential Needs</h2>
            <p class="text-sm text-blue-600 mb-4">These are your basic living expenses that you need to maintain your lifestyle.</p>
            <div class="space-y-4">
                <div>
                    <label for="housing" class="block text-sm font-medium text-gray-700">Housing (Rent/Mortgage) (€)</label>
                    <input type="number" step="0.01" name="housing" id="housing" class="expense-input mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required min="0" placeholder="Enter your monthly housing costs" value="{{ $budget->detailed_expenses['housing'] ?? 0 }}">
                </div>
                <div>
                    <label for="utilities" class="block text-sm font-medium text-gray-700">Utilities (Electricity, Water, Internet) (€)</label>
                    <input type="number" step="0.01" name="utilities" id="utilities" class="expense-input mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required min="0" placeholder="Enter your monthly utilities costs" value="{{ $budget->detailed_expenses['utilities'] ?? 0 }}">
                </div>
                <div>
                    <label for="transportation" class="block text-sm font-medium text-gray-700">Transportation (Fuel, Public Transport) (€)</label>
                    <input type="number" step="0.01" name="transportation" id="transportation" class="expense-input mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required min="0" placeholder="Enter your monthly transportation costs" value="{{ $budget->detailed_expenses['transportation'] ?? 0 }}">
                </div>
                <div>
                    <label for="groceries" class="block text-sm font-medium text-gray-700">Groceries (€)</label>
                    <input type="number" step="0.01" name="groceries" id="groceries" class="expense-input mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required min="0" placeholder="Enter your monthly grocery expenses" value="{{ $budget->detailed_expenses['groceries'] ?? 0 }}">
                </div>
                <div>
                    <label for="insurance" class="block text-sm font-medium text-gray-700">Insurance (Health, Car, etc.) (€)</label>
                    <input type="number" step="0.01" name="insurance" id="insurance" class="expense-input mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required min="0" placeholder="Enter your monthly insurance costs" value="{{ $budget->detailed_expenses['insurance'] ?? 0 }}">
                </div>
                <div>
                    <label for="loan_payments" class="block text-sm font-medium text-gray-700">Loan Payments (excluding mortgage) (€)</label>
                    <input type="number" step="0.01" name="loan_payments" id="loan_payments" class="expense-input mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required min="0" placeholder="Enter your monthly loan payments" value="{{ $budget->detailed_expenses['loan_payments'] ?? 0 }}">
                </div>
                <div>
                    <label for="personal_care" class="block text-sm font-medium text-gray-700">Personal Care (Haircuts, etc.) (€)</label>
                    <input type="number" step="0.01" name="personal_care" id="personal_care" class="expense-input mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required min="0" placeholder="Enter your monthly personal care expenses" value="{{ $budget->detailed_expenses['personal_care'] ?? 0 }}">
                </div>
            </div>
        </div>

        <!-- Wants Section -->
        <div class="mt-8 p-4 bg-purple-50 rounded-lg">
            <h2 class="text-xl font-semibold mb-4 text-purple-800">Lifestyle Wants</h2>
            <p class="text-sm text-purple-600 mb-4">These are expenses that enhance your lifestyle but aren't essential for basic living.</p>
            <div class="space-y-4">
                <div>
                    <label for="dining_out" class="block text-sm font-medium text-gray-700">Dining Out (€)</label>
                    <input type="number" step="0.01" name="dining_out" id="dining_out" class="expense-input mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-purple-500 focus:border-purple-500" required min="0" placeholder="Enter your monthly dining out expenses" value="{{ $budget->detailed_expenses['dining_out'] ?? 0 }}">
                </div>
                <div>
                    <label for="shopping" class="block text-sm font-medium text-gray-700">Shopping (€)</label>
                    <input type="number" step="0.01" name="shopping" id="shopping" class="expense-input mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-purple-500 focus:border-purple-500" required min="0" placeholder="Enter your monthly shopping expenses" value="{{ $budget->detailed_expenses['shopping'] ?? 0 }}">
                </div>
                <div>
                    <label for="entertainment" class="block text-sm font-medium text-gray-700">Entertainment (€)</label>
                    <input type="number" step="0.01" name="entertainment" id="entertainment" class="expense-input mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-purple-500 focus:border-purple-500" required min="0" placeholder="Enter your monthly entertainment expenses" value="{{ $budget->detailed_expenses['entertainment'] ?? 0 }}">
                </div>
                <div>
                    <label for="subscriptions" class="block text-sm font-medium text-gray-700">Subscriptions (Netflix, Gym, etc.) (€)</label>
                    <input type="number" step="0.01" name="subscriptions" id="subscriptions" class="expense-input mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-purple-500 focus:border-purple-500" required min="0" placeholder="Enter your monthly subscription costs" value="{{ $budget->detailed_expenses['subscriptions'] ?? 0 }}">
                </div>
                <div>
                    <label for="miscellaneous" class="block text-sm font-medium text-gray-700">Miscellaneous (Unexpected or small expenses) (€)</label>
                    <input type="number" step="0.01" name="miscellaneous" id="miscellaneous" class="expense-input mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-purple-500 focus:border-purple-500" required min="0" placeholder="Enter your monthly miscellaneous expenses" value="{{ $budget->detailed_expenses['miscellaneous'] ?? 0 }}">
                </div>
            </div>
        </div>

        <!-- Additional Information -->
        <div class="mt-8 p-4 bg-gray-50 rounded-lg">
            <h2 class="text-xl font-semibold mb-4 text-gray-800">Additional Information</h2>
            <div class="space-y-4">
                <div>
                    <label for="dependents" class="block text-sm font-medium text-gray-700">Number of Dependents</label>
                    <input type="number" name="dependents" id="dependents" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-gray-500 focus:border-gray-500" required min="0" placeholder="Enter number of dependents" value="{{ $budget->dependents }}">
                </div>
                <div>
                    <label for="debt" class="block text-sm font-medium text-gray-700">Do you have significant debt?</label>
                    <select name="debt" id="debt" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-gray-500 focus:border-gray-500" required>
                        <option value="">Select an option</option>
                        <option value="no" {{ $budget->debt === 'no' ? 'selected' : '' }}>No</option>
                        <option value="yes" {{ $budget->debt === 'yes' ? 'selected' : '' }}>Yes</option>
                    </select>
                </div>
                <div>
                    <label for="goal" class="block text-sm font-medium text-gray-700">Main Financial Goal</label>
                    <select name="goal" id="goal" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-gray-500 focus:border-gray-500" required>
                        <option value="">Select your main goal</option>
                        <option value="retirement" {{ $budget->goal === 'retirement' ? 'selected' : '' }}>Save for retirement</option>
                        <option value="house" {{ $budget->goal === 'house' ? 'selected' : '' }}>Buy a house</option>
                        <option value="debt" {{ $budget->goal === 'debt' ? 'selected' : '' }}>Pay off debt</option>
                        <option value="emergency" {{ $budget->goal === 'emergency' ? 'selected' : '' }}>Build emergency fund</option>
                        <option value="other" {{ $budget->goal === 'other' ? 'selected' : '' }}>Other</option>
                    </select>
                </div>
            </div>
        </div>

        <button type="submit" id="submitButton" class="w-full bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700">Save Changes</button>
    </form>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('budgetForm');
    const incomeInput = document.getElementById('income');
    const expenseInputs = document.querySelectorAll('.expense-input');
    const totalExpensesDisplay = document.getElementById('totalExpensesDisplay');
    const totalExpensesElement = document.getElementById('totalExpenses');
    const remainingIncomeElement = document.getElementById('remainingIncome');
    const submitButton = document.getElementById('submitButton');

    function calculateTotals() {
        const income = parseFloat(incomeInput.value) || 0;
        let totalExpenses = 0;

        expenseInputs.forEach(input => {
            totalExpenses += parseFloat(input.value) || 0;
        });

        const remainingIncome = income - totalExpenses;

        // Update display
        totalExpensesElement.textContent = `€${totalExpenses.toFixed(2)}`;
        remainingIncomeElement.textContent = `€${remainingIncome.toFixed(2)}`;

        // Show/hide the total expenses display
        if (income > 0) {
            totalExpensesDisplay.classList.remove('hidden');
        } else {
            totalExpensesDisplay.classList.add('hidden');
        }

        // Update colors based on remaining income
        if (remainingIncome < 0) {
            remainingIncomeElement.classList.remove('text-yellow-800');
            remainingIncomeElement.classList.add('text-red-600');
            submitButton.disabled = true;
            submitButton.classList.add('opacity-50', 'cursor-not-allowed');
            submitButton.classList.remove('hover:bg-green-700');
        } else {
            remainingIncomeElement.classList.remove('text-red-600');
            remainingIncomeElement.classList.add('text-yellow-800');
            submitButton.disabled = false;
            submitButton.classList.remove('opacity-50', 'cursor-not-allowed');
            submitButton.classList.add('hover:bg-green-700');
        }
    }

    // Add event listeners
    incomeInput.addEventListener('input', calculateTotals);
    expenseInputs.forEach(input => {
        input.addEventListener('input', calculateTotals);
    });

    // Initial calculation
    calculateTotals();

    // Function to validate all numeric inputs
    function validateNumericInputs() {
        const numericInputs = document.querySelectorAll('input[type="number"]');
        numericInputs.forEach(input => {
            if (input.value === '') {
                input.value = '0';
            }
        });
    }

    // Add event listeners to all numeric inputs
    document.querySelectorAll('input[type="number"]').forEach(input => {
        // When input loses focus
        input.addEventListener('blur', function() {
            if (this.value === '') {
                this.value = ''; // Leave empty for user to fill, or change to '0' if preferred
            }
        });

        // When input is focused
        input.addEventListener('focus', function() {
            if (this.value === '0') {
                this.value = '';
            }
        });
    });

    // Validate before form submission
    document.getElementById('budgetForm').addEventListener('submit', function(e) {
        validateNumericInputs();
    });
});
</script>
@endpush
@endsection 