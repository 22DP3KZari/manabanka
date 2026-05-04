@extends('layouts.app')

@section('title', __('common.budget_planner') . ' - manaBanka')

@section('content')
<div class="max-w-xl sm:max-w-2xl mx-auto px-4 sm:px-5 lg:px-6 py-6">
    <div class="mb-5">
        <h1 class="text-xl sm:text-2xl font-bold text-white tracking-tight">{{ __('common.budget_planner') }}</h1>
        <p class="text-sm text-gray-500 mt-1 leading-snug max-w-prose">{{ __('common.set_monthly_budgets') }}</p>
    </div>

    <form action="{{ route('budget-planner.calculate') }}" method="POST" id="budgetForm" class="card-solid overflow-hidden border border-slate-600/40 shadow-lg shadow-black/25 ring-1 ring-white/5">
        @csrf

        <div class="px-4 py-3 sm:px-5 sm:py-3.5 border-b border-slate-700/60 bg-slate-900/35">
            <p class="text-xs font-medium uppercase tracking-wide text-gray-500">
                <span>{{ __('common.budget_name') }}</span>
                <span class="text-gray-600 mx-1" aria-hidden="true">/</span>
                <span>{{ __('common.monthly_income') }}</span>
            </p>
        </div>

        <div class="p-4 sm:p-5 space-y-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="name" class="block text-xs font-medium text-gray-400 mb-1.5">{{ __('common.budget_name') }} <span class="text-gray-600 font-normal">({{ __('common.optional') }})</span></label>
                    <input type="text" name="name" id="name" maxlength="255"
                           class="w-full px-3 py-2.5 text-sm bg-slate-900/40 border border-slate-600/60 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-revolut-purple/80 focus:border-revolut-purple/50 transition-shadow"
                           placeholder="{{ __('common.budget_name_placeholder') }}">
                </div>
                <div>
                    <label for="income" class="block text-xs font-medium text-gray-400 mb-1.5">{{ __('common.monthly_income') }} <span class="text-gray-500">(€)</span></label>
                    <input type="number" step="0.01" name="income" id="income" required min="0" placeholder="0.00"
                           class="w-full px-3 py-2.5 text-sm tabular-nums bg-slate-900/40 border border-slate-600/60 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-revolut-purple/80 focus:border-revolut-purple/50 transition-shadow">
                </div>
            </div>

            <div id="budgetSummary" class="hidden rounded-lg border border-slate-600/50 bg-slate-900/30 px-3 py-2.5 sm:px-4 sm:py-3">
                <div class="flex flex-wrap items-center justify-between gap-3">
                    <div>
                        <div class="text-[11px] font-medium uppercase tracking-wide text-gray-500">{{ __('common.total_budget') }}</div>
                        <div id="totalBudget" class="text-base sm:text-lg font-semibold tabular-nums text-white">€0.00</div>
                    </div>
                    <div class="hidden sm:block h-8 w-px bg-slate-600/50 shrink-0" aria-hidden="true"></div>
                    <div class="text-right sm:text-left">
                        <div class="text-[11px] font-medium uppercase tracking-wide text-gray-500">{{ __('common.remaining') }}</div>
                        <div id="remainingAmount" class="text-base sm:text-lg font-semibold tabular-nums text-green-400">€0.00</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="border-t border-slate-700/60 bg-slate-900/25 px-4 py-3 sm:px-5">
            <h2 class="text-sm font-semibold text-white">{{ __('common.category_budgets') }}</h2>
        </div>

        <div class="p-3 sm:p-4 pb-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
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
                <div class="group flex items-center gap-2 rounded-lg border border-slate-600/35 bg-slate-800/40 px-2.5 py-2 transition-colors hover:border-revolut-purple/35 hover:bg-slate-800/70">
                    <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-md bg-slate-900/60 border border-slate-600/40 text-base shadow-sm" aria-hidden="true">
                        {{ $info['icon'] }}
                    </div>
                    <label for="{{ $category }}" class="flex-1 min-w-0 text-sm font-medium text-gray-200 leading-tight group-hover:text-white transition-colors cursor-pointer">
                        {{ $info['label'] }}
                    </label>
                    <div class="relative w-[5.5rem] sm:w-24 shrink-0">
                        <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-2 text-[11px] font-medium text-gray-500" aria-hidden="true">€</span>
                        <input type="number" step="0.01" name="{{ $category }}" id="{{ $category }}" min="0" placeholder="0" value="0"
                               class="category-budget-input w-full pl-5 pr-2 py-1.5 text-sm tabular-nums text-right bg-slate-900/50 border border-slate-600/60 rounded-md text-white placeholder-gray-600 focus:outline-none focus:ring-2 focus:ring-revolut-purple/70 focus:border-revolut-purple/50">
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <div class="px-4 pb-4 sm:px-5 sm:pb-5 pt-0">
            <button type="submit" id="submitButton"
                    class="w-full rounded-lg bg-revolut-purple hover:bg-revolut-purple-dark text-white text-sm font-semibold py-2.5 shadow-md shadow-revolut-purple/25 transition-all duration-200 hover:shadow-revolut-purple/35 disabled:opacity-45 disabled:cursor-not-allowed disabled:shadow-none">
                {{ __('common.create_budget') }}
            </button>
        </div>
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

        totalBudgetEl.textContent = '€' + totalBudget.toFixed(2);
        remainingAmountEl.textContent = '€' + remaining.toFixed(2);

        if (income > 0 || totalBudget > 0) {
            budgetSummary.classList.remove('hidden');
        } else {
            budgetSummary.classList.add('hidden');
        }

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

    function debounce(fn, ms) {
        let t;
        return function() {
            clearTimeout(t);
            t = setTimeout(fn, ms);
        };
    }
    const debouncedCalculate = debounce(calculateBudget, 120);

    incomeInput.addEventListener('input', debouncedCalculate);
    categoryInputs.forEach(input => {
        input.addEventListener('input', debouncedCalculate);
    });

    calculateBudget();
});
</script>
@endpush
@endsection
