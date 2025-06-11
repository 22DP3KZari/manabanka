@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-3xl font-bold mb-8">Your Personalized Budget Plan</h1>

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold mb-4">Monthly Income</h2>
                <p class="text-3xl font-bold text-green-600">${{ number_format($income, 2) }}</p>
            </div>
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold mb-4">Total Fixed Expenses</h2>
                <p class="text-3xl font-bold text-red-600">${{ number_format($fixed_expenses, 2) }}</p>
            </div>
        </div>

        <!-- Budget Breakdown -->
        <div class="bg-white rounded-lg shadow p-6 mb-8">
            <h2 class="text-xl font-semibold mb-4">Budget Breakdown</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                    <canvas id="budgetChart" width="400" height="400"></canvas>
                </div>
                <div class="space-y-4">
                    <div class="flex justify-between items-center">
                        <span class="font-medium">Needs (Fixed Expenses)</span>
                        <span class="text-red-600">${{ number_format($fixed_expenses, 2) }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="font-medium">Wants</span>
                        <span class="text-blue-600">${{ number_format($wants, 2) }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="font-medium">Savings</span>
                        <span class="text-green-600">${{ number_format($savings, 2) }}</span>
                    </div>
                    @if($debt_repayment > 0)
                    <div class="flex justify-between items-center">
                        <span class="font-medium">Debt Repayment</span>
                        <span class="text-purple-600">${{ number_format($debt_repayment, 2) }}</span>
                    </div>
                    @endif
                    <div class="flex justify-between items-center">
                        <span class="font-medium">Other</span>
                        <span class="text-gray-600">${{ number_format($other, 2) }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Detailed Expenses -->
        <div class="bg-white rounded-lg shadow p-6 mb-8">
            <h2 class="text-xl font-semibold mb-4">Detailed Expenses</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach($detailed_expenses as $category => $amount)
                    @if($amount > 0)
                    <div class="flex justify-between items-center p-3 bg-gray-50 rounded">
                        <span class="font-medium capitalize">{{ str_replace('_', ' ', $category) }}</span>
                        <span class="text-gray-700">${{ number_format($amount, 2) }}</span>
                    </div>
                    @endif
                @endforeach
            </div>
        </div>

        <!-- Personal Information -->
        <div class="bg-white rounded-lg shadow p-6 mb-8">
            <h2 class="text-xl font-semibold mb-4">Your Information</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <p class="text-gray-600">Age</p>
                    <p class="font-medium">{{ $age }} years</p>
                </div>
                <div>
                    <p class="text-gray-600">Dependents</p>
                    <p class="font-medium">{{ $dependents }}</p>
                </div>
                <div>
                    <p class="text-gray-600">Debt</p>
                    <p class="font-medium">{{ ucfirst($debt) }}</p>
                </div>
                <div>
                    <p class="text-gray-600">Financial Goal</p>
                    <p class="font-medium capitalize">{{ str_replace('_', ' ', $goal) }}</p>
                </div>
            </div>
        </div>

        <!-- Personalized Advice -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-semibold mb-4">Personalized Advice</h2>
            <ul class="list-disc list-inside space-y-2">
                @foreach($advice as $tip)
                    <li class="text-gray-700">{{ $tip }}</li>
                @endforeach
            </ul>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('budgetChart').getContext('2d');
    
    // Prepare data for the chart
    const labels = ['Needs', 'Wants', 'Savings'];
    const data = [{{ $fixed_expenses }}, {{ $wants }}, {{ $savings }}];
    const backgroundColors = ['#EF4444', '#3B82F6', '#10B981'];
    
    // Add debt repayment if applicable
    if ({{ $debt_repayment }} > 0) {
        labels.push('Debt Repayment');
        data.push({{ $debt_repayment }});
        backgroundColors.push('#8B5CF6');
    }
    
    // Add other/buffer
    labels.push('Other');
    data.push({{ $other }});
    backgroundColors.push('#6B7280');

    new Chart(ctx, {
        type: 'pie',
        data: {
            labels: labels,
            datasets: [{
                data: data,
                backgroundColor: backgroundColors,
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'right'
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const value = context.raw;
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = ((value / total) * 100).toFixed(1);
                            return `${context.label}: $${value.toFixed(2)} (${percentage}%)`;
                        }
                    }
                }
            }
        }
    });
});
</script>
@endpush
@endsection 