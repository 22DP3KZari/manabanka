@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto py-10">
    <h1 class="text-3xl font-bold mb-6">Edit Budget Plan</h1>
    <a href="{{ route('budgets.index') }}" class="mb-6 inline-block bg-yellow-600 text-white px-6 py-2 rounded hover:bg-yellow-700">Back to My Budgets</a>
    <form action="{{ route('budgets.update', $budget->id) }}" method="POST" class="space-y-6 bg-white p-6 rounded-lg shadow">
        @csrf
        @method('PATCH')
        <div>
            <label for="dependents" class="block text-sm font-medium text-gray-700">Number of Dependents</label>
            <input type="number" name="dependents" id="dependents" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" min="0" value="{{ old('dependents', $budget->dependents) }}">
        </div>
        <div>
            <label for="debt" class="block text-sm font-medium text-gray-700">Do you have significant debt?</label>
            <select name="debt" id="debt" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                <option value="" {{ old('debt', $budget->debt) == '' ? 'selected' : '' }}>Not specified</option>
                <option value="no" {{ old('debt', $budget->debt) == 'no' ? 'selected' : '' }}>No</option>
                <option value="yes" {{ old('debt', $budget->debt) == 'yes' ? 'selected' : '' }}>Yes</option>
            </select>
        </div>
        <div>
            <label for="goal" class="block text-sm font-medium text-gray-700">Main Financial Goal</label>
            <select name="goal" id="goal" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                <option value="" {{ old('goal', $budget->goal) == '' ? 'selected' : '' }}>Not specified</option>
                <option value="retirement" {{ old('goal', $budget->goal) == 'retirement' ? 'selected' : '' }}>Save for retirement</option>
                <option value="house" {{ old('goal', $budget->goal) == 'house' ? 'selected' : '' }}>Buy a house</option>
                <option value="debt" {{ old('goal', $budget->goal) == 'debt' ? 'selected' : '' }}>Pay off debt</option>
                <option value="emergency" {{ old('goal', $budget->goal) == 'emergency' ? 'selected' : '' }}>Build emergency fund</option>
                <option value="other" {{ old('goal', $budget->goal) == 'other' ? 'selected' : '' }}>Other</option>
            </select>
        </div>
        <div>
            <label for="income" class="block text-sm font-medium text-gray-700">Monthly Income (€)</label>
            <input type="number" step="0.01" name="income" id="income" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required value="{{ old('income', $budget->income) }}">
        </div>
        <div>
            <label for="fixed_expenses" class="block text-sm font-medium text-gray-700">Total Fixed Expenses (€)</label>
            <input type="number" step="0.01" name="fixed_expenses" id="fixed_expenses" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required value="{{ old('fixed_expenses', $budget->fixed_expenses) }}">
        </div>
        <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700">Save Changes</button>
    </form>
</div>
@endsection 