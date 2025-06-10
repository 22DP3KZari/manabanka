@extends('layouts.app')

@section('title', 'My Budgets - manaBanka')

@section('content')
<div class="max-w-3xl mx-auto py-10">
    <h1 class="text-3xl font-bold mb-6">My Budgets</h1>
    <a href="{{ route('budget-planner.index') }}" class="mb-6 inline-block bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700">New Budget Plan</a>
    @if($budgets->isEmpty())
        <div class="bg-white p-6 rounded-lg shadow text-gray-600">You have not created any budget plans yet.</div>
    @else
        <div class="bg-white p-6 rounded-lg shadow overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 whitespace-nowrap">
                <thead>
                    <tr>
                        <th class="px-4 py-2 text-left">Date</th>
                        <th class="px-4 py-2 text-left">Age</th>
                        <th class="px-4 py-2 text-left">Dependents</th>
                        <th class="px-4 py-2 text-left">Debt</th>
                        <th class="px-4 py-2 text-left">Goal</th>
                        <th class="px-4 py-2 text-left">Income (€)</th>
                        <th class="px-4 py-2 text-left">Needs (€)</th>
                        <th class="px-4 py-2 text-left">Wants (€)</th>
                        <th class="px-4 py-2 text-left">Savings (€)</th>
                        <th class="px-4 py-2 text-left">Other (€)</th>
                        <th class="px-4 py-2 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($budgets as $budget)
                        <tr>
                            <td class="px-4 py-2">{{ $budget->created_at->format('Y-m-d H:i') }}</td>
                            <td class="px-4 py-2">{{ $budget->age }}</td>
                            <td class="px-4 py-2">{{ $budget->dependents !== null ? $budget->dependents : 'Not specified' }}</td>
                            <td class="px-4 py-2">{{ $budget->debt !== null ? ucfirst($budget->debt) : 'Not specified' }}</td>
                            <td class="px-4 py-2">{{ $budget->goal !== null ? ucfirst($budget->goal) : 'Not specified' }}</td>
                            <td class="px-4 py-2">€{{ number_format($budget->income, 2) }}</td>
                            <td class="px-4 py-2">€{{ number_format($budget->fixed_expenses, 2) }}</td>
                            <td class="px-4 py-2">€{{ number_format($budget->wants, 2) }}</td>
                            <td class="px-4 py-2">€{{ number_format($budget->savings, 2) }}</td>
                            <td class="px-4 py-2">€{{ number_format($budget->other, 2) }}</td>
                            <td class="px-4 py-2">
                                <a href="{{ route('budgets.show', $budget->id) }}" class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700 mr-2">View</a>
                                <a href="{{ route('budgets.edit', $budget->id) }}" class="bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700 mr-2">Edit</a>
                                <form action="{{ route('budgets.destroy', $budget->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this budget plan?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection 