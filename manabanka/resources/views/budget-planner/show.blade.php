@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-3xl font-bold mb-8">Budget Plan Details</h1>

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold mb-4">Monthly Income</h2>
                <p class="text-3xl font-bold text-green-600">${{ number_format($budget->income, 2) }}</p>
            </div>
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold mb-4">Total Fixed Expenses</h2>
                <p class="text-3xl font-bold text-red-600">${{ number_format($budget->fixed_expenses, 2) }}</p>
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
                        <span class="text-red-600">${{ number_format($budget->fixed_expenses, 2) }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="font-medium">Wants</span>
                        <span class="text-blue-600">${{ number_format($budget->wants, 2) }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="font-medium">Savings</span>
                        <span class="text-green-600">${{ number_format($budget->savings, 2) }}</span>
                    </div>
                    @if($budget->debt !== null)
                    <div class="flex justify-between items-center">
                        <span class="font-medium">Debt Repayment</span>
                        <span class="text-purple-600">${{ number_format($budget->debt_repayment, 2) }}</span>
                    </div>
                    @endif
                    <div class="flex justify-between items-center">
                        <span class="font-medium">Other (Buffer)</span>
                        <span class="text-gray-600">${{ number_format($budget->other, 2) }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Detailed Expenses -->
        <div class="bg-white rounded-lg shadow p-6 mb-8">
            <h2 class="text-xl font-semibold mb-4">Detailed Expenses</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach($budget->detailed_expenses as $category => $amount)
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
                    <p class="font-medium">{{ $budget->age }} years</p>
                </div>
                <div>
                    <p class="text-gray-600">Dependents</p>
                    <p class="font-medium">{{ $budget->dependents }}</p>
                </div>
                <div>
                    <p class="text-gray-600">Debt</p>
                    <p class="font-medium">{{ ucfirst($budget->debt) }}</p>
                </div>
                <div>
                    <p class="text-gray-600">Financial Goal</p>
                    <p class="font-medium capitalize">{{ str_replace('_', ' ', $budget->goal) }}</p>
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
    const canvas = document.getElementById('budgetChart');
    if (!canvas) {
        console.error('Canvas element with id "budgetChart" not found.');
        return;
    }

    const ctx = canvas.getContext('2d');

    // Destroy existing chart instance if it exists
    if (window.myBudgetChart instanceof Chart) {
        window.myBudgetChart.destroy();
    }
    
    // Prepare data for the chart
    const labels = ['Needs', 'Wants', 'Savings'];
    const data = [{{ $fixed_expenses ?? 0 }}, {{ $wants ?? 0 }}, {{ $savings ?? 0 }}];
    const backgroundColors = ['#EF4444', '#3B82F6', '#10B981'];
    
    // Add debt repayment if applicable
    if ({{ $debt_repayment ?? 0 }} > 0) {
        labels.push('Debt Repayment');
        data.push({{ $debt_repayment ?? 0 }});
        backgroundColors.push('#8B5CF6');
    }
    
    // Add other/buffer
    labels.push('Other');
    data.push({{ $other ?? 0 }});
    backgroundColors.push('#6B7280');

    // Log data for debugging
    console.log('Chart Labels:', labels);
    console.log('Chart Data:', data);
    console.log('Fixed Expenses:', {{ $fixed_expenses ?? 0 }});
    console.log('Wants:', {{ $wants ?? 0 }});
    console.log('Savings:', {{ $savings ?? 0 }});
    console.log('Debt Repayment:', {{ $debt_repayment ?? 0 }});
    console.log('Other:', {{ $other ?? 0 }});

    window.myBudgetChart = new Chart(ctx, {
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