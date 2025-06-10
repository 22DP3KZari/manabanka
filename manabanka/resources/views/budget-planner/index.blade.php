@extends('layouts.app')

@section('title', 'Budget Planner - manaBanka')

@section('content')
<div class="max-w-2xl mx-auto py-10">
    <h1 class="text-3xl font-bold mb-6">Budget Planner</h1>
    <a href="{{ route('budgets.index') }}" class="mb-6 inline-block bg-yellow-600 text-white px-6 py-2 rounded hover:bg-yellow-700">My Budgets</a>
    <form action="{{ route('budget-planner.calculate') }}" method="POST" class="space-y-4 bg-white p-6 rounded-lg shadow">
        @csrf
        <div>
            <label for="age" class="block text-sm font-medium text-gray-700">Age</label>
            <input type="number" name="age" id="age" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
        </div>
        <div>
            <label for="income" class="block text-sm font-medium text-gray-700">Monthly Income (€)</label>
            <input type="number" step="0.01" name="income" id="income" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
        </div>

        <h2 class="text-xl font-semibold mt-8 mb-4">Monthly Expenses</h2>

        <div>
            <label for="housing" class="block text-sm font-medium text-gray-700">Housing (Rent/Mortgage) (€)</label>
            <input type="number" step="0.01" name="housing" id="housing" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" value="0" min="0">
        </div>
        <div>
            <label for="utilities" class="block text-sm font-medium text-gray-700">Utilities (Electricity, Water, Internet) (€)</label>
            <input type="number" step="0.01" name="utilities" id="utilities" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" value="0" min="0">
        </div>
        <div>
            <label for="transportation" class="block text-sm font-medium text-gray-700">Transportation (Fuel, Public Transport) (€)</label>
            <input type="number" step="0.01" name="transportation" id="transportation" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" value="0" min="0">
        </div>
        <div>
            <label for="groceries" class="block text-sm font-medium text-gray-700">Groceries (€)</label>
            <input type="number" step="0.01" name="groceries" id="groceries" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" value="0" min="0">
        </div>
        <div>
            <label for="dining_out" class="block text-sm font-medium text-gray-700">Dining Out (€)</label>
            <input type="number" step="0.01" name="dining_out" id="dining_out" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" value="0" min="0">
        </div>
        <div>
            <label for="shopping" class="block text-sm font-medium text-gray-700">Shopping (€)</label>
            <input type="number" step="0.01" name="shopping" id="shopping" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" value="0" min="0">
        </div>
        <div>
            <label for="entertainment" class="block text-sm font-medium text-gray-700">Entertainment (€)</label>
            <input type="number" step="0.01" name="entertainment" id="entertainment" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" value="0" min="0">
        </div>
        <div>
            <label for="subscriptions" class="block text-sm font-medium text-gray-700">Subscriptions (Netflix, Gym, etc.) (€)</label>
            <input type="number" step="0.01" name="subscriptions" id="subscriptions" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" value="0" min="0">
        </div>
        <div>
            <label for="personal_care" class="block text-sm font-medium text-gray-700">Personal Care (Haircuts, etc.) (€)</label>
            <input type="number" step="0.01" name="personal_care" id="personal_care" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" value="0" min="0">
        </div>
        <div>
            <label for="loan_payments" class="block text-sm font-medium text-gray-700">Loan Payments (excluding mortgage) (€)</label>
            <input type="number" step="0.01" name="loan_payments" id="loan_payments" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" value="0" min="0">
        </div>
        <div>
            <label for="insurance" class="block text-sm font-medium text-gray-700">Insurance (Health, Car, etc.) (€)</label>
            <input type="number" step="0.01" name="insurance" id="insurance" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" value="0" min="0">
        </div>
        <div>
            <label for="miscellaneous" class="block text-sm font-medium text-gray-700">Miscellaneous (Unexpected or small expenses) (€)</label>
            <input type="number" step="0.01" name="miscellaneous" id="miscellaneous" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" value="0" min="0">
        </div>
        <div>
            <label for="dependents" class="block text-sm font-medium text-gray-700">Number of Dependents</label>
            <input type="number" name="dependents" id="dependents" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" value="0" min="0" required>
        </div>
        <div>
            <label for="debt" class="block text-sm font-medium text-gray-700">Do you have significant debt?</label>
            <select name="debt" id="debt" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                <option value="no">No</option>
                <option value="yes">Yes</option>
            </select>
        </div>
        <div>
            <label for="goal" class="block text-sm font-medium text-gray-700">Main Financial Goal</label>
            <select name="goal" id="goal" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                <option value="retirement">Save for retirement</option>
                <option value="house">Buy a house</option>
                <option value="debt">Pay off debt</option>
                <option value="emergency">Build emergency fund</option>
                <option value="other">Other</option>
            </select>
        </div>
        <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700">Calculate Budget</button>
    </form>
</div>
@endsection 