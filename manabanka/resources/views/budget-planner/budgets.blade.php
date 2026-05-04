@extends('layouts.app')

@section('title', __('common.my_budgets') . ' - manaBanka')

@section('content')
<div class="max-w-xl sm:max-w-2xl mx-auto px-4 sm:px-5 lg:px-6 py-6">
    <div class="mb-5 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
        <div class="min-w-0">
            <h1 class="text-xl sm:text-2xl font-bold text-white tracking-tight">{{ __('common.my_budgets') }}</h1>
            <p class="text-sm text-gray-500 mt-1 leading-snug max-w-prose">{{ __('common.budget_overview') }}</p>
        </div>
        <a href="{{ route('budget-planner.index') }}"
           class="inline-flex shrink-0 items-center justify-center self-start rounded-lg bg-revolut-purple px-4 py-2.5 text-sm font-semibold text-white shadow-md shadow-revolut-purple/25 transition-all duration-200 hover:bg-revolut-purple-dark hover:shadow-revolut-purple/35 sm:self-auto">
            {{ __('common.new_budget') }}
        </a>
    </div>

    @if($budgets->isEmpty())
        <div class="card-solid border border-slate-600/40 p-8 text-center shadow-lg shadow-black/20 ring-1 ring-white/5">
            <p class="text-sm text-gray-400 mb-5 max-w-xs mx-auto">{{ __('common.no_budgets') }}</p>
            <a href="{{ route('budget-planner.index') }}"
               class="inline-flex items-center justify-center rounded-lg bg-revolut-purple px-5 py-2.5 text-sm font-semibold text-white shadow-md shadow-revolut-purple/25 transition-all hover:bg-revolut-purple-dark">
                {{ __('common.create_first_budget') }}
            </a>
        </div>
    @else
        @if(isset($selectedBudget))
            @if(!$budgetData->isEmpty())
            <div class="card-solid mb-5 overflow-hidden border border-slate-600/40 shadow-lg shadow-black/20 ring-1 ring-white/5">
                @php
                    $monthName = \Carbon\Carbon::create($year, $month, 1)->translatedFormat('F Y');
                @endphp
                @if($budgets->count() > 1)
                <div class="border-b border-slate-700/60 bg-slate-900/35 px-4 py-3 sm:px-5">
                    <div class="mb-1.5 flex items-center justify-between gap-2">
                        <label for="budgetSelector" class="block text-[10px] font-medium uppercase tracking-wide text-gray-500">{{ __('common.select_budget') ?? 'Select Budget' }}</label>
                        <form action="{{ route('budgets.destroy', $selectedBudget) }}" method="POST" class="shrink-0" onsubmit="return confirm('{{ __('common.confirm_delete_budget') }}');">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="flex h-8 w-8 items-center justify-center rounded-md text-gray-500 transition-colors hover:bg-red-500/15 hover:text-red-400 focus:outline-none focus-visible:ring-2 focus-visible:ring-red-400/50"
                                    title="{{ __('common.delete') }}"
                                    aria-label="{{ __('common.delete') }}">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </form>
                    </div>
                    <select id="budgetSelector"
                            onchange="window.location.href='{{ route('budgets.index') }}?budget_id=' + this.value"
                            class="w-full rounded-lg border border-slate-600/60 bg-slate-900/50 px-3 py-2 text-sm text-white focus:outline-none focus:ring-2 focus:ring-revolut-purple/70 focus:border-revolut-purple/50">
                        @foreach($budgets as $budget)
                            <option value="{{ $budget->id }}" {{ (isset($selectedBudget) && $selectedBudget->id === $budget->id) ? 'selected' : '' }}>
                                {{ $budget->name ?? 'Budget ' . $budget->created_at->format('M Y') }} ({{ $budget->created_at->format('d.m.Y') }})
                            </option>
                        @endforeach
                    </select>
                </div>
                @endif
                <div class="border-b border-slate-700/60 bg-slate-900/20 px-4 py-2.5 sm:px-5">
                    <div class="flex items-start justify-between gap-2">
                        <div class="min-w-0">
                            @if($budgets->count() === 1)
                                <h2 class="text-sm font-semibold text-white leading-snug">
                                    {{ $selectedBudget->name ?? 'Budget ' . $selectedBudget->created_at->format('M Y') }}
                                </h2>
                            @endif
                            <p class="text-xs text-gray-500 {{ $budgets->count() === 1 ? 'mt-0.5' : '' }}">{{ $monthName }}</p>
                        </div>
                        @if($budgets->count() === 1)
                        <form action="{{ route('budgets.destroy', $selectedBudget) }}" method="POST" class="shrink-0" onsubmit="return confirm('{{ __('common.confirm_delete_budget') }}');">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="flex h-8 w-8 items-center justify-center rounded-md text-gray-500 transition-colors hover:bg-red-500/15 hover:text-red-400 focus:outline-none focus-visible:ring-2 focus-visible:ring-red-400/50"
                                    title="{{ __('common.delete') }}"
                                    aria-label="{{ __('common.delete') }}">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </form>
                        @endif
                    </div>
                </div>
                <div class="grid grid-cols-1 divide-y divide-slate-700/60 border-b border-slate-700/60 sm:grid-cols-3 sm:divide-x sm:divide-y-0">
                    <div class="px-4 py-3 sm:px-5">
                        <div class="text-[10px] font-medium uppercase tracking-wide text-gray-500">{{ __('common.monthly_income') }}</div>
                        <div class="mt-0.5 text-lg font-semibold tabular-nums text-white">€{{ number_format($selectedBudget->income, 2, ',', '.') }}</div>
                    </div>
                    <div class="px-4 py-3 sm:px-5">
                        <div class="text-[10px] font-medium uppercase tracking-wide text-gray-500">{{ __('common.total_budgeted') }}</div>
                        <div class="mt-0.5 text-lg font-semibold tabular-nums text-white">€{{ number_format($budgetData->sum('budget'), 2, ',', '.') }}</div>
                    </div>
                    <div class="px-4 py-3 sm:px-5">
                        <div class="text-[10px] font-medium uppercase tracking-wide text-gray-500">{{ __('common.total_spent') }}</div>
                        <div class="mt-0.5 text-lg font-semibold tabular-nums text-white">€{{ number_format($budgetData->sum('actual'), 2, ',', '.') }}</div>
                    </div>
                </div>
            </div>
            @else
            <div class="card-solid mb-6 overflow-hidden border border-slate-600/40 shadow-lg shadow-black/20 ring-1 ring-white/5">
                @if($budgets->count() > 1)
                <div class="border-b border-slate-700/60 bg-slate-900/35 px-4 py-3 sm:px-5 text-left">
                    <div class="mb-1.5 flex items-center justify-between gap-2">
                        <label for="budgetSelectorEmpty" class="block text-[10px] font-medium uppercase tracking-wide text-gray-500">{{ __('common.select_budget') ?? 'Select Budget' }}</label>
                        <form action="{{ route('budgets.destroy', $selectedBudget) }}" method="POST" class="shrink-0" onsubmit="return confirm('{{ __('common.confirm_delete_budget') }}');">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="flex h-8 w-8 items-center justify-center rounded-md text-gray-500 transition-colors hover:bg-red-500/15 hover:text-red-400 focus:outline-none focus-visible:ring-2 focus-visible:ring-red-400/50"
                                    title="{{ __('common.delete') }}"
                                    aria-label="{{ __('common.delete') }}">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </form>
                    </div>
                    <select id="budgetSelectorEmpty"
                            onchange="window.location.href='{{ route('budgets.index') }}?budget_id=' + this.value"
                            class="w-full rounded-lg border border-slate-600/60 bg-slate-900/50 px-3 py-2 text-sm text-white focus:outline-none focus:ring-2 focus:ring-revolut-purple/70 focus:border-revolut-purple/50">
                        @foreach($budgets as $budget)
                            <option value="{{ $budget->id }}" {{ (isset($selectedBudget) && $selectedBudget->id === $budget->id) ? 'selected' : '' }}>
                                {{ $budget->name ?? 'Budget ' . $budget->created_at->format('M Y') }} ({{ $budget->created_at->format('d.m.Y') }})
                            </option>
                        @endforeach
                    </select>
                </div>
                @endif
                <div class="flex items-start justify-between gap-3 border-b border-slate-700/60 px-4 py-3 sm:px-5 {{ $budgets->count() > 1 ? 'bg-slate-900/20' : 'bg-slate-900/35' }}">
                    <div class="min-w-0 text-left">
                        <h2 class="text-sm font-semibold text-white leading-snug">{{ __('common.current_month_budget') }}</h2>
                        <p class="mt-0.5 text-xs text-gray-500">{{ $selectedBudget->name ?? 'Budget ' . $selectedBudget->created_at->format('M Y') }}</p>
                    </div>
                    @if($budgets->count() === 1)
                    <form action="{{ route('budgets.destroy', $selectedBudget) }}" method="POST" class="shrink-0" onsubmit="return confirm('{{ __('common.confirm_delete_budget') }}');">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="flex h-8 w-8 items-center justify-center rounded-md text-gray-500 transition-colors hover:bg-red-500/15 hover:text-red-400 focus:outline-none focus-visible:ring-2 focus-visible:ring-red-400/50"
                                title="{{ __('common.delete') }}"
                                aria-label="{{ __('common.delete') }}">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </form>
                    @endif
                </div>
                <div class="p-6 text-center">
                    <p class="text-sm text-gray-400">{{ __('common.no_category_budgets_for_month') ?? 'This budget has no category budgets set for the current month.' }}</p>
                </div>
            </div>
            @endif
        @endif

        @if($budgetData->isNotEmpty())
        @php
            $categoryTranslations = [
                'housing' => __('common.category_housing'),
                'utilities' => __('common.category_utilities'),
                'transportation' => __('common.category_transportation'),
                'groceries' => __('common.category_groceries'),
                'dining_out' => __('common.category_dining_out'),
                'shopping' => __('common.category_shopping'),
                'entertainment' => __('common.category_entertainment'),
                'subscriptions' => __('common.category_subscriptions'),
                'personal_care' => __('common.category_personal_care'),
                'loan_payments' => __('common.category_loan_payments'),
                'insurance' => __('common.category_insurance'),
                'miscellaneous' => __('common.category_miscellaneous'),
            ];
            $categoryIcons = [
                'housing' => '🏠',
                'utilities' => '💡',
                'transportation' => '🚌',
                'groceries' => '🛒',
                'dining_out' => '🍴',
                'shopping' => '🛍️',
                'entertainment' => '🎬',
                'subscriptions' => '📱',
                'personal_care' => '💇',
                'loan_payments' => '💳',
                'insurance' => '🛡️',
                'miscellaneous' => '📦',
            ];
            $statusColors = [
                'on_track' => 'bg-green-500/20 border-green-500/35 text-green-300',
                'warning' => 'bg-amber-500/15 border-amber-500/35 text-amber-300',
                'over_budget' => 'bg-red-500/20 border-red-500/35 text-red-300',
            ];
        @endphp

        <div id="budgetCategoryList" class="scroll-list grid grid-cols-1 md:grid-cols-2 gap-3">
            @foreach($budgetData as $data)
                @php
                    $statusColor = $statusColors[$data['status']] ?? 'bg-gray-500/15 border-gray-500/30 text-gray-400';
                    $label = $categoryTranslations[$data['category']] ?? ucfirst(str_replace('_', ' ', $data['category']));
                    $barColor = $data['status'] === 'on_track' ? 'bg-green-500' : ($data['status'] === 'warning' ? 'bg-amber-400' : 'bg-red-500');
                    $barWidth = min(100, $data['percentage']);
                @endphp
                <div class="card-solid group flex flex-col border border-slate-600/40 p-4 transition-all duration-200 hover:border-revolut-purple/45 hover:bg-slate-800/85 shadow-md shadow-black/15 ring-1 ring-white/5">
                    <div class="flex items-start gap-3">
                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-slate-900/60 border border-slate-600/50 text-lg shadow-sm" aria-hidden="true">
                            {{ $categoryIcons[$data['category']] ?? '💰' }}
                        </div>
                        <div class="min-w-0 flex-1">
                            <div class="flex items-start justify-between gap-2">
                                <h3 class="text-sm font-semibold text-white leading-snug group-hover:text-revolut-purple-light transition-colors">
                                    {{ $label }}
                                </h3>
                                <button type="button"
                                        class="category-edit-btn shrink-0 rounded-lg border border-slate-600/50 bg-slate-900/40 p-2 text-gray-400 transition-all hover:border-revolut-purple/40 hover:bg-revolut-purple/15 hover:text-revolut-purple"
                                        title="{{ __('common.edit_spending') }}"
                                        data-category="{{ $data['category'] }}"
                                        data-label="{{ e($label) }}"
                                        data-actual="{{ $data['actual'] }}"
                                        data-budget="{{ $data['budget'] }}"
                                        data-budget-id="{{ $data['budget_id'] ?? (isset($selectedBudget) ? $selectedBudget->id : 0) }}"
                                        data-remaining="{{ $data['remaining'] }}">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </button>
                            </div>

                            <div class="mt-3 grid grid-cols-2 gap-2">
                                <div class="rounded-md border border-slate-600/35 bg-slate-900/35 px-2 py-1.5">
                                    <div class="text-[10px] font-medium uppercase tracking-wide text-gray-500">{{ __('common.budget') }}</div>
                                    <div class="text-sm font-semibold tabular-nums text-white">€{{ number_format($data['budget'], 2, ',', '.') }}</div>
                                </div>
                                <div class="rounded-md border border-slate-600/35 bg-slate-900/35 px-2 py-1.5">
                                    <div class="text-[10px] font-medium uppercase tracking-wide text-gray-500">{{ __('common.spent') }}</div>
                                    <div class="text-sm font-semibold tabular-nums text-white">€{{ number_format($data['actual'], 2, ',', '.') }}</div>
                                </div>
                            </div>

                            <div class="mt-3 flex flex-wrap items-center justify-between gap-2">
                                <div class="text-xs font-semibold tabular-nums {{ $data['remaining'] >= 0 ? 'text-green-400' : 'text-red-400' }}">
                                    {{ $data['remaining'] >= 0 ? '+' : '' }}€{{ number_format($data['remaining'], 2, ',', '.') }}
                                </div>
                                <span class="inline-flex items-center rounded-full border px-2 py-0.5 text-[11px] font-medium tabular-nums {{ $statusColor }}">
                                    {{ round($data['percentage']) }}%
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="mt-3 h-1.5 w-full overflow-hidden rounded-full bg-slate-700/80">
                        <div class="{{ $barColor }} h-full rounded-full transition-all duration-300" style="width: {{ $barWidth }}%"></div>
                    </div>
                </div>
            @endforeach
        </div>
        @endif
    @endif
</div>

<!-- Edit Spending Modal -->
<div id="editSpendingModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 p-4 backdrop-blur-sm">
    <div class="max-w-md w-full overflow-hidden rounded-2xl border border-slate-600/50 bg-slate-800 shadow-2xl shadow-black/40 ring-1 ring-white/10">
        <div class="flex items-center justify-between border-b border-slate-700/60 px-5 py-4">
            <h3 class="truncate pr-3 text-lg font-semibold text-white" id="modalCategoryName"></h3>
            <button type="button" onclick="closeEditModal()" class="shrink-0 rounded-lg p-1.5 text-gray-400 transition-colors hover:bg-slate-700/60 hover:text-white">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <form id="editSpendingForm" method="POST" class="space-y-4 px-5 py-5">
            @csrf
            <input type="hidden" id="modalCategory" name="category">
            <input type="hidden" id="modalBudgetId" name="budget_id">

            <div class="grid grid-cols-2 gap-3">
                <div class="rounded-lg border border-slate-600/40 bg-slate-900/35 px-3 py-2">
                    <label class="block text-[10px] font-medium uppercase tracking-wide text-gray-500">{{ __('common.budget') }}</label>
                    <div class="mt-0.5 text-base font-semibold tabular-nums text-white" id="modalBudgetAmount"></div>
                </div>
                <div class="rounded-lg border border-slate-600/40 bg-slate-900/35 px-3 py-2">
                    <label class="block text-[10px] font-medium uppercase tracking-wide text-gray-500">{{ __('common.currently_spent') }}</label>
                    <div class="mt-0.5 text-base font-semibold tabular-nums text-white" id="modalCurrentSpent"></div>
                </div>
            </div>

            <div>
                <label for="spentAmount" class="mb-1.5 block text-sm font-medium text-gray-300">{{ __('common.add_amount') }} (€)</label>
                <input type="number"
                       step="0.01"
                       min="0"
                       name="amount"
                       id="spentAmount"
                       class="w-full rounded-lg border border-slate-600/60 bg-slate-900/40 px-3 py-2.5 text-sm tabular-nums text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-revolut-purple/70 focus:border-revolut-purple/50"
                       required
                       placeholder="0.00"
                       value="">
                <p class="mt-1 text-xs text-gray-500">{{ __('common.add_amount_hint') }}</p>
            </div>

            <div class="rounded-lg border border-slate-600/40 bg-slate-900/35 px-3 py-2.5">
                <div class="text-xs text-gray-500">{{ __('common.new_total') }}</div>
                <div class="text-lg font-bold tabular-nums text-white" id="newTotalAmount">€0,00</div>
            </div>

            <div class="flex gap-3 pt-1">
                <button type="button"
                        onclick="closeEditModal()"
                        class="flex-1 rounded-lg border border-slate-600/60 bg-slate-900/40 px-4 py-2.5 text-sm font-medium text-white transition-colors hover:bg-slate-700/50">
                    {{ __('common.cancel') }}
                </button>
                <button type="submit"
                        class="flex-1 rounded-lg bg-revolut-purple px-4 py-2.5 text-sm font-semibold text-white shadow-md shadow-revolut-purple/25 transition-all hover:bg-revolut-purple-light">
                    {{ __('common.save') }}
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
let currentSpentAmount = 0;
let budgetAmountValue = 0;

function openEditModal(category, categoryName, currentSpent, budgetAmount, budgetId, remaining) {
    currentSpentAmount = parseFloat(currentSpent) || 0;
    budgetAmountValue = parseFloat(budgetAmount) || 0;

    document.getElementById('modalCategory').value = category;
    document.getElementById('modalCategoryName').textContent = categoryName;
    document.getElementById('modalBudgetAmount').textContent = '€' + budgetAmountValue.toFixed(2).replace('.', ',');
    document.getElementById('modalCurrentSpent').textContent = '€' + currentSpentAmount.toFixed(2).replace('.', ',');
    document.getElementById('spentAmount').value = '';
    document.getElementById('modalBudgetId').value = budgetId;
    document.getElementById('editSpendingForm').action = '{{ route("budgets.update-spending") }}';
    document.getElementById('editSpendingModal').classList.remove('hidden');
    document.getElementById('editSpendingModal').classList.add('flex');
    updateNewTotal();
}

function updateNewTotal() {
    const addAmount = parseFloat(document.getElementById('spentAmount').value) || 0;
    const newTotal = currentSpentAmount + addAmount;
    document.getElementById('newTotalAmount').textContent = '€' + newTotal.toFixed(2).replace('.', ',');

    const newTotalEl = document.getElementById('newTotalAmount');
    if (newTotal > budgetAmountValue) {
        newTotalEl.classList.remove('text-white', 'text-yellow-400');
        newTotalEl.classList.add('text-red-400');
    } else if (newTotal > budgetAmountValue * 0.8) {
        newTotalEl.classList.remove('text-white', 'text-red-400');
        newTotalEl.classList.add('text-yellow-400');
    } else {
        newTotalEl.classList.remove('text-yellow-400', 'text-red-400');
        newTotalEl.classList.add('text-white');
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const spentAmountInput = document.getElementById('spentAmount');
    if (spentAmountInput) {
        spentAmountInput.addEventListener('input', updateNewTotal);
    }

    const list = document.getElementById('budgetCategoryList');
    if (list) {
        list.addEventListener('click', function(e) {
            const btn = e.target.closest('.category-edit-btn');
            if (!btn) return;
            openEditModal(
                btn.dataset.category,
                btn.dataset.label,
                parseFloat(btn.dataset.actual) || 0,
                parseFloat(btn.dataset.budget) || 0,
                parseInt(btn.dataset.budgetId, 10) || 0,
                parseFloat(btn.dataset.remaining) || 0
            );
        });
    }
});

function closeEditModal() {
    document.getElementById('editSpendingModal').classList.add('hidden');
    document.getElementById('editSpendingModal').classList.remove('flex');
}

document.getElementById('editSpendingModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeEditModal();
    }
});
</script>
@endpush
@endsection
