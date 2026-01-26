@extends('layouts.app')

@section('title', __('common.budget_planner') . ' - manaBanka')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-white mb-2">{{ __('common.budget_planner') }}</h1>
        <p class="text-gray-400">{{ __('common.set_monthly_budgets') }}</p>
    </div>

    <form action="{{ route('budget-planner.calculate') }}" method="POST" class="space-y-6" id="budgetForm">
        @csrf
        
        <!-- Budget Name -->
        <div class="bg-slate-800/40 backdrop-blur-sm border border-slate-700/50 rounded-xl p-6">
            <label for="name" class="block text-sm font-medium text-white mb-3">{{ __('common.budget_name') }} <span class="text-gray-500 text-xs">({{ __('common.optional') }})</span></label>
            <input type="text" name="name" id="name" 
                   class="w-full px-4 py-3 bg-slate-700/50 border border-slate-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-revolut-purple focus:border-transparent" 
                   placeholder="{{ __('common.budget_name_placeholder') }}" maxlength="255">
        </div>
        
        <!-- Monthly Income -->
        <div class="bg-slate-800/40 backdrop-blur-sm border border-slate-700/50 rounded-xl p-6">
            <label for="income" class="block text-sm font-medium text-white mb-3">{{ __('common.monthly_income') }} (€)</label>
            <input type="number" step="0.01" name="income" id="income" 
                   class="w-full px-4 py-3 bg-slate-700/50 border border-slate-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-revolut-purple focus:border-transparent" 
                   required min="0" placeholder="0.00">
        </div>

        <!-- Budget Summary -->
        <div id="budgetSummary" class="bg-slate-800/40 backdrop-blur-sm border border-slate-700/50 rounded-xl p-6 hidden">
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <div class="text-sm text-gray-400 mb-1">{{ __('common.total_budget') }}</div>
                    <div id="totalBudget" class="text-2xl font-bold text-white">€0.00</div>
                </div>
                <div>
                    <div class="text-sm text-gray-400 mb-1">{{ __('common.remaining') }}</div>
                    <div id="remainingAmount" class="text-2xl font-bold text-green-400">€0.00</div>
                </div>
            </div>
        </div>

        <!-- Category Budgets -->
        <div class="bg-slate-800/40 backdrop-blur-sm border border-slate-700/50 rounded-xl p-6">
            <h2 class="text-xl font-semibold text-white mb-4">{{ __('common.category_budgets') }}</h2>
            <div class="space-y-4">
                @php
                    $categories = [
                        'housing' => ['icon' => '🏠', 'label' => __('common.category_housing')],
                        'utilities' => ['icon' => '💡', 'label' => __('common.category_utilities')],
                        'transportation' => ['icon' => '🚌', 'label' => __('common.category_transportation')],
                        'groceries' => ['icon' => '🛒', 'label' => __('common.category_groceries')],
                        'dining_out' => ['icon' => '🍴', 'label' => __('common.category_dining_out')],
                        'shopping' => ['icon' => '🛍️', 'label' => __('common.category_shopping')],
                        'entertainment' => ['icon' => '🎬', 'label' => __('common.category_entertainment')],
                        'subscriptions' => ['icon' => '📱', 'label' => __('common.category_subscriptions')],
                        'personal_care' => ['icon' => '💇', 'label' => __('common.category_personal_care')],
                        'loan_payments' => ['icon' => '💳', 'label' => __('common.category_loan_payments')],
                        'insurance' => ['icon' => '🛡️', 'label' => __('common.category_insurance')],
                        'miscellaneous' => ['icon' => '📦', 'label' => __('common.category_miscellaneous')],
                    ];
                @endphp

                @foreach($categories as $category => $info)
                <div class="flex items-center space-x-4">
                    <div class="w-10 h-10 rounded-lg bg-slate-700/50 flex items-center justify-center text-2xl flex-shrink-0">
                        {{ $info['icon'] }}
                    </div>
                    <label for="{{ $category }}" class="flex-1 text-white font-medium min-w-0">
                        {{ $info['label'] }}
                    </label>
                    <div class="w-32">
                        <input type="number" step="0.01" name="{{ $category }}" id="{{ $category }}" 
                               class="category-budget-input w-full px-3 py-2 bg-slate-700/50 border border-slate-600 rounded-lg text-white text-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-revolut-purple focus:border-transparent" 
                               min="0" placeholder="0.00" value="0">
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <button type="submit" id="submitButton" 
                class="w-full bg-revolut-purple hover:bg-revolut-purple-dark text-white font-medium px-6 py-3 rounded-lg transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
            {{ __('common.create_budget') }}
        </button>
    </form>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const incomeInput = document.getElementById('income');
    const categoryInputs = document.querySelectorAll('.category-budget-input');
    const budgetSummary = document.getElementById('budgetSummary');
    const totalBudgetEl = document.getElementById('totalBudget');
    const remainingAmountEl = document.getElementById('remainingAmount');
    const submitButton = document.getElementById('submitButton');

    function calculateBudget() {
        const income = parseFloat(incomeInput.value) || 0;
        let totalBudget = 0;

        categoryInputs.forEach(input => {
            totalBudget += parseFloat(input.value) || 0;
        });

        const remaining = income - totalBudget;

        // Update display
        totalBudgetEl.textContent = `€${totalBudget.toFixed(2)}`;
        remainingAmountEl.textContent = `€${remaining.toFixed(2)}`;

        // Show/hide summary
        if (income > 0 || totalBudget > 0) {
            budgetSummary.classList.remove('hidden');
        } else {
            budgetSummary.classList.add('hidden');
        }

        // Update remaining color
        if (remaining < 0) {
            remainingAmountEl.classList.remove('text-green-400');
            remainingAmountEl.classList.add('text-red-400');
            submitButton.disabled = true;
        } else {
            remainingAmountEl.classList.remove('text-red-400');
            remainingAmountEl.classList.add('text-green-400');
            submitButton.disabled = false;
        }
    }

    incomeInput.addEventListener('input', calculateBudget);
    categoryInputs.forEach(input => {
        input.addEventListener('input', calculateBudget);
    });

    calculateBudget();
});
</script>
@endpush
@endsection
