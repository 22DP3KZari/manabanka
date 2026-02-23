@extends('layouts.app')

@section('title', __('common.etf_calculator_title') . ' - manaBanka')

@section('content')
<div class="max-w-4xl mx-auto px-3 sm:px-6 lg:px-8 py-4 sm:py-8">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-white mb-2">{{ __('common.etf_calculator_title') }}</h1>
        <p class="text-gray-400">{{ __('common.etf_calculator_subtitle') }}</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Inputs -->
        <div class="lg:col-span-2 space-y-6">
            <div class="card-solid p-6">
                <h2 class="text-lg font-semibold text-white mb-4">{{ __('common.etf_calc_parameters') }}</h2>
                <div class="space-y-4">
                    <div>
                        <label for="initial" class="block text-sm font-medium text-gray-300 mb-2">{{ __('common.etf_calc_initial') }} (€)</label>
                        <input type="number" step="0.01" min="0" max="99999999" id="initial" value="500"
                               class="w-full px-4 py-3 bg-slate-700/50 border border-slate-600 rounded-lg text-white placeholder-gray-500 focus:ring-2 focus:ring-revolut-purple focus:border-transparent">
                    </div>
                    <div>
                        <label for="contribution" class="block text-sm font-medium text-gray-300 mb-2">{{ __('common.etf_calc_contributions') }} (€)</label>
                        <input type="number" step="0.01" min="0" max="999999" id="contribution" value="500"
                               class="w-full px-4 py-3 bg-slate-700/50 border border-slate-600 rounded-lg text-white placeholder-gray-500 focus:ring-2 focus:ring-revolut-purple focus:border-transparent">
                    </div>
                    <div>
                        <label for="frequency" class="block text-sm font-medium text-gray-300 mb-2">{{ __('common.etf_calc_frequency') }}</label>
                        <select id="frequency" class="w-full px-4 py-3 bg-slate-700/50 border border-slate-600 rounded-lg text-white focus:ring-2 focus:ring-revolut-purple focus:border-transparent">
                            <option value="12">{{ __('common.etf_calc_per_month') }}</option>
                            <option value="4">{{ __('common.etf_calc_per_quarter') }}</option>
                            <option value="2">{{ __('common.etf_calc_per_six_months') }}</option>
                            <option value="1">{{ __('common.etf_calc_per_year') }}</option>
                        </select>
                    </div>
                    <div>
                        <label for="dynamic" class="block text-sm font-medium text-gray-300 mb-2">{{ __('common.etf_calc_dynamic') }} (%)</label>
                        <input type="number" step="0.1" min="0" max="5" id="dynamic" value="0"
                               class="w-full px-4 py-3 bg-slate-700/50 border border-slate-600 rounded-lg text-white placeholder-gray-500 focus:ring-2 focus:ring-revolut-purple focus:border-transparent">
                    </div>
                    <div>
                        <label for="years" class="block text-sm font-medium text-gray-300 mb-2">{{ __('common.etf_calc_years') }}</label>
                        <input type="number" step="1" min="1" max="50" id="years" value="25"
                               class="w-full px-4 py-3 bg-slate-700/50 border border-slate-600 rounded-lg text-white placeholder-gray-500 focus:ring-2 focus:ring-revolut-purple focus:border-transparent">
                    </div>
                    <div>
                        <label for="rate" class="block text-sm font-medium text-gray-300 mb-2">{{ __('common.etf_calc_rate') }}</label>
                        <input type="number" step="0.1" min="0.1" max="10" id="rate" value="6"
                               class="w-full px-4 py-3 bg-slate-700/50 border border-slate-600 rounded-lg text-white placeholder-gray-500 focus:ring-2 focus:ring-revolut-purple focus:border-transparent">
                    </div>
                </div>
                <button type="button" id="calculateBtn" class="mt-4 w-full py-3 bg-revolut-purple hover:bg-revolut-purple-dark text-white font-medium rounded-lg transition-colors">
                    {{ __('common.etf_calc_calculate') }}
                </button>
            </div>
        </div>

        <!-- Results -->
        <div class="space-y-6">
            <div id="resultsCard" class="card-solid p-6 hidden">
                <h2 class="text-lg font-semibold text-white mb-4">{{ __('common.etf_calc_results') }}</h2>
                <div class="space-y-3">
                    <div>
                        <p class="text-xs text-gray-400">{{ __('common.etf_calc_total_investment') }}</p>
                        <p id="totalInvestment" class="text-xl font-bold text-white">€0,00</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400">{{ __('common.etf_calc_total_returns') }}</p>
                        <p id="totalReturns" class="text-xl font-bold text-green-400">€0,00</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400">{{ __('common.etf_calc_total_savings') }}</p>
                        <p id="totalSavings" class="text-xl font-bold text-revolut-purple">€0,00</p>
                    </div>
                </div>
            </div>
            <p class="text-xs text-gray-500">{{ __('common.etf_calc_disclaimer') }}</p>
        </div>
    </div>

    <!-- Year table -->
    <div id="tableCard" class="mt-6 card-solid p-6 overflow-hidden hidden">
        <h2 class="text-lg font-semibold text-white mb-4">{{ __('common.etf_calc_table_title') }}</h2>
        <div class="overflow-x-auto -mx-2">
            <table class="w-full min-w-[600px] text-sm">
                <thead>
                    <tr class="text-left text-gray-400 border-b border-slate-600">
                        <th class="pb-3 pr-4 font-medium">{{ __('common.etf_calc_table_year') }}</th>
                        <th class="pb-3 pr-4 font-medium">{{ __('common.etf_calc_table_start') }}</th>
                        <th class="pb-3 pr-4 font-medium">{{ __('common.etf_calc_table_contributions') }}</th>
                        <th class="pb-3 pr-4 font-medium">{{ __('common.etf_calc_table_returns') }}</th>
                        <th class="pb-3 font-medium">{{ __('common.etf_calc_table_end') }}</th>
                    </tr>
                </thead>
                <tbody id="tableBody" class="text-gray-300">
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const initial = document.getElementById('initial');
    const contribution = document.getElementById('contribution');
    const frequency = document.getElementById('frequency');
    const dynamic = document.getElementById('dynamic');
    const years = document.getElementById('years');
    const rate = document.getElementById('rate');
    const calculateBtn = document.getElementById('calculateBtn');
    const resultsCard = document.getElementById('resultsCard');
    const tableCard = document.getElementById('tableCard');
    const totalInvestmentEl = document.getElementById('totalInvestment');
    const totalReturnsEl = document.getElementById('totalReturns');
    const totalSavingsEl = document.getElementById('totalSavings');
    const tableBody = document.getElementById('tableBody');

    function formatEur(n) {
        return '€' + new Intl.NumberFormat('de-DE', { minimumFractionDigits: 2, maximumFractionDigits: 2 }).format(n);
    }

    function runCalculation() {
        const initialVal = Math.max(0, parseFloat(initial.value) || 0);
        const contributionVal = Math.max(0, parseFloat(contribution.value) || 0);
        const periodsPerYear = parseInt(frequency.value, 10) || 1;
        const dynamicVal = Math.max(0, Math.min(5, parseFloat(dynamic.value) || 0)) / 100;
        const yearsVal = Math.max(1, Math.min(50, parseInt(years.value, 10) || 1));
        const rateVal = Math.max(0.1, Math.min(10, parseFloat(rate.value) || 0)) / 100;

        let balance = initialVal;
        let totalContributions = 0;
        const rows = [];
        let contributionThisYear = contributionVal * periodsPerYear;

        for (let y = 1; y <= yearsVal; y++) {
            const startBalance = balance;
            const contrib = contributionThisYear;
            totalContributions += contrib;
            balance = (balance + contrib) * (1 + rateVal);
            const returnsThisYear = balance - startBalance - contrib;
            rows.push({
                year: y,
                start: startBalance,
                contributions: contrib,
                returns: returnsThisYear,
                end: balance
            });
            contributionThisYear *= (1 + dynamicVal);
        }

        const totalInvested = initialVal + totalContributions;
        const totalReturns = balance - totalInvested;

        totalInvestmentEl.textContent = formatEur(totalInvested);
        totalReturnsEl.textContent = formatEur(totalReturns);
        totalSavingsEl.textContent = formatEur(balance);
        resultsCard.classList.remove('hidden');

        tableBody.innerHTML = rows.map(r =>
            '<tr class="border-b border-slate-700/50 hover:bg-slate-700/20">' +
            '<td class="py-3 pr-4 text-white">' + r.year + '</td>' +
            '<td class="py-3 pr-4">' + formatEur(r.start) + '</td>' +
            '<td class="py-3 pr-4">' + formatEur(r.contributions) + '</td>' +
            '<td class="py-3 pr-4 text-green-400">' + formatEur(r.returns) + '</td>' +
            '<td class="py-3 text-white font-medium">' + formatEur(r.end) + '</td>' +
            '</tr>'
        ).join('');
        tableCard.classList.remove('hidden');
    }

    function debounce(fn, ms) {
        let t;
        return function() {
            clearTimeout(t);
            t = setTimeout(fn, ms);
        };
    }
    const debouncedRun = debounce(runCalculation, 120);

    calculateBtn.addEventListener('click', runCalculation);
    [initial, contribution, frequency, dynamic, years, rate].forEach(el => el.addEventListener('change', runCalculation));
    [initial, contribution, years, rate].forEach(el => el.addEventListener('input', function() {
        if (this.value !== '') debouncedRun();
    }));

    runCalculation();
});
</script>
@endsection
