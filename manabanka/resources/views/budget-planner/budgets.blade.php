@extends('layouts.app')

@section('title', __('common.my_budgets') . ' - manaBanka')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-white mb-2">{{ __('common.my_budgets') }}</h1>
            <p class="text-gray-400">{{ __('common.budget_overview') }}</p>
        </div>
        <a href="{{ route('budget-planner.index') }}" 
           class="bg-revolut-purple hover:bg-revolut-purple-dark text-white font-medium px-6 py-3 rounded-lg transition-colors">
            {{ __('common.new_budget') }}
        </a>
    </div>

    @if($budgets->isEmpty())
        <div class="bg-slate-800/40 backdrop-blur-sm border border-slate-700/50 rounded-xl p-8 text-center">
            <div class="text-gray-400 mb-4">{{ __('common.no_budgets') }}</div>
            <a href="{{ route('budget-planner.index') }}" 
               class="inline-block bg-revolut-purple hover:bg-revolut-purple-dark text-white font-medium px-6 py-3 rounded-lg transition-colors">
                {{ __('common.create_first_budget') }}
            </a>
        </div>
    @else
        <!-- Budgets List -->
        <div class="space-y-4 mb-6">
            @foreach($budgets as $budget)
                <div class="bg-slate-800/40 backdrop-blur-sm border border-slate-700/50 rounded-xl p-6 hover:bg-slate-800/60 transition-colors">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-xl font-semibold text-white mb-1">
                                {{ $budget->name ?? 'Budget ' . $budget->created_at->format('M Y') }}
                            </h3>
                            <div class="text-sm text-gray-400">
                                {{ __('common.created') }}: {{ $budget->created_at->format('d.m.Y') }}
                                • {{ __('common.income') }}: €{{ number_format($budget->income, 2, ',', '.') }}
                            </div>
                        </div>
                        <div class="flex items-center space-x-3">
                            <form action="{{ route('budgets.destroy', $budget) }}" method="POST" class="inline" onsubmit="return confirm('{{ __('common.confirm_delete_budget') }}');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-4 py-2 bg-red-500/20 hover:bg-red-500/30 text-red-400 rounded-lg transition-colors text-sm font-medium">
                                    {{ __('common.delete') }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Budget Selector -->
        @if($budgets->count() > 1)
        <div class="bg-slate-800/40 backdrop-blur-sm border border-slate-700/50 rounded-xl p-4 mb-6">
            <label for="budgetSelector" class="block text-sm font-medium text-gray-400 mb-2">{{ __('common.select_budget') ?? 'Select Budget' }}</label>
            <select id="budgetSelector" 
                    onchange="window.location.href='{{ route('budgets.index') }}?budget_id=' + this.value"
                    class="w-full md:w-auto px-4 py-2 bg-slate-700/50 border border-slate-600 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-revolut-purple focus:border-transparent">
                @foreach($budgets as $budget)
                    <option value="{{ $budget->id }}" {{ (isset($selectedBudget) && $selectedBudget->id === $budget->id) ? 'selected' : '' }}>
                        {{ $budget->name ?? 'Budget ' . $budget->created_at->format('M Y') }} ({{ $budget->created_at->format('d.m.Y') }})
                    </option>
                @endforeach
            </select>
        </div>
        @endif

        <!-- Current Month Budget Summary -->
        @if(isset($selectedBudget))
            @if(!$budgetData->isEmpty())
            <div class="bg-slate-800/40 backdrop-blur-sm border border-slate-700/50 rounded-xl p-6 mb-6">
                @php
                    $monthName = \Carbon\Carbon::create($year, $month, 1)->format('F Y');
                @endphp
                <h2 class="text-xl font-semibold text-white mb-4">{{ $selectedBudget->name ?? 'Budget ' . $selectedBudget->created_at->format('M Y') }} - {{ $monthName }}</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <div class="text-sm text-gray-400 mb-1">{{ __('common.monthly_income') }}</div>
                        <div class="text-2xl font-bold text-white">€{{ number_format($selectedBudget->income, 2, ',', '.') }}</div>
                    </div>
                    <div>
                        <div class="text-sm text-gray-400 mb-1">{{ __('common.total_budgeted') }}</div>
                        <div class="text-2xl font-bold text-white">€{{ number_format($budgetData->sum('budget'), 2, ',', '.') }}</div>
                    </div>
                    <div>
                        <div class="text-sm text-gray-400 mb-1">{{ __('common.total_spent') }}</div>
                        <div class="text-2xl font-bold text-white">€{{ number_format($budgetData->sum('actual'), 2, ',', '.') }}</div>
                    </div>
                </div>
            </div>
            @else
            <div class="bg-slate-800/40 backdrop-blur-sm border border-slate-700/50 rounded-xl p-6 mb-6 text-center">
                <h2 class="text-xl font-semibold text-white mb-2">{{ __('common.current_month_budget') }}: {{ $selectedBudget->name ?? 'Budget ' . $selectedBudget->created_at->format('M Y') }}</h2>
                <p class="text-gray-400">{{ __('common.no_category_budgets_for_month') ?? 'This budget has no category budgets set for the current month.' }}</p>
            </div>
            @endif
        @endif

        <!-- Category Budgets -->
        <div class="space-y-4">
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
            @endphp

            @foreach($budgetData as $data)
                @php
                    $statusColors = [
                        'on_track' => 'bg-green-500/20 border-green-500/30 text-green-400',
                        'warning' => 'bg-yellow-500/20 border-yellow-500/30 text-yellow-400',
                        'over_budget' => 'bg-red-500/20 border-red-500/30 text-red-400',
                    ];
                    $statusColor = $statusColors[$data['status']] ?? 'bg-gray-500/20 border-gray-500/30 text-gray-400';
                @endphp
                <div class="bg-slate-800/40 backdrop-blur-sm border border-slate-700/50 rounded-xl p-5 hover:bg-slate-800/60 transition-colors">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center space-x-4 flex-1">
                            <div class="w-12 h-12 rounded-lg bg-slate-700/50 flex items-center justify-center text-2xl">
                                {{ $categoryIcons[$data['category']] ?? '💰' }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="text-lg font-semibold text-white mb-1">
                                    {{ $categoryTranslations[$data['category']] ?? ucfirst(str_replace('_', ' ', $data['category'])) }}
                                </div>
                                <div class="flex items-center space-x-4 text-sm">
                                    <span class="text-gray-400">{{ __('common.budget') }}: <span class="text-white font-medium">€{{ number_format($data['budget'], 2, ',', '.') }}</span></span>
                                    <span class="text-gray-400">{{ __('common.spent') }}: <span class="text-white font-medium">€{{ number_format($data['actual'], 2, ',', '.') }}</span></span>
                                </div>
                            </div>
                        </div>
                        <div class="text-right ml-4 flex items-center space-x-3">
                            <div>
                                <div class="text-sm font-medium mb-1 {{ $data['remaining'] >= 0 ? 'text-green-400' : 'text-red-400' }}">
                                    {{ $data['remaining'] >= 0 ? '+' : '' }}€{{ number_format($data['remaining'], 2, ',', '.') }}
                                </div>
                                <div class="text-xs {{ $statusColor }} px-2 py-1 rounded-full inline-block">
                                    {{ round($data['percentage']) }}%
                                </div>
                            </div>
                            <button onclick="openEditModal('{{ $data['category'] }}', '{{ $categoryTranslations[$data['category']] }}', {{ $data['actual'] }}, {{ $data['budget'] }}, {{ $data['budget_id'] ?? (isset($selectedBudget) ? $selectedBudget->id : 0) }}, {{ $data['remaining'] }})" 
                                    class="p-2 text-gray-400 hover:text-revolut-purple transition-colors" 
                                    title="{{ __('common.edit_spending') }}">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    
                    <!-- Progress Bar -->
                    <div class="w-full bg-slate-700 rounded-full h-2 mb-2">
                        @php
                            $barColor = $data['status'] === 'on_track' ? 'bg-green-500' : ($data['status'] === 'warning' ? 'bg-yellow-500' : 'bg-red-500');
                            $barWidth = min(100, $data['percentage']);
                        @endphp
                        <div class="{{ $barColor }} h-2 rounded-full transition-all duration-300" style="width: {{ $barWidth }}%"></div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

<!-- Edit Spending Modal -->
<div id="editSpendingModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 backdrop-blur-sm">
    <div class="bg-slate-800 border border-slate-700 rounded-xl p-6 max-w-md w-full mx-4">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-xl font-semibold text-white" id="modalCategoryName"></h3>
            <button onclick="closeEditModal()" class="text-gray-400 hover:text-white transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        
        <form id="editSpendingForm" method="POST" class="space-y-4">
            @csrf
            <input type="hidden" id="modalCategory" name="category">
            <input type="hidden" id="modalBudgetId" name="budget_id">
            
        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-sm font-medium text-gray-400 mb-1">{{ __('common.budget') }}</label>
                <div class="text-lg font-semibold text-white" id="modalBudgetAmount"></div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-400 mb-1">{{ __('common.currently_spent') }}</label>
                <div class="text-lg font-semibold text-white" id="modalCurrentSpent"></div>
            </div>
        </div>
        
        <div>
            <label for="spentAmount" class="block text-sm font-medium text-white mb-2">{{ __('common.add_amount') }} (€)</label>
            <input type="number" 
                   step="0.01" 
                   min="0" 
                   name="amount" 
                   id="spentAmount" 
                   class="w-full px-4 py-3 bg-slate-700/50 border border-slate-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-revolut-purple focus:border-transparent text-lg [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none" 
                   required 
                   placeholder="0.00"
                   value="">
            <p class="text-xs text-gray-400 mt-1">{{ __('common.add_amount_hint') }}</p>
        </div>
        
        <div class="bg-slate-700/30 rounded-lg p-3">
            <div class="text-sm text-gray-400 mb-1">{{ __('common.new_total') }}</div>
            <div class="text-xl font-bold text-white" id="newTotalAmount">€0,00</div>
        </div>
            
            <div class="flex space-x-3 pt-4">
                <button type="button" 
                        onclick="closeEditModal()" 
                        class="flex-1 px-4 py-3 bg-slate-700/50 border border-slate-600 rounded-lg text-white font-medium hover:bg-slate-700 transition-colors">
                    {{ __('common.cancel') }}
                </button>
                <button type="submit" 
                        class="flex-1 px-4 py-3 bg-revolut-purple rounded-lg text-white font-medium hover:bg-revolut-purple-light transition-colors">
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
    
    // Update color based on budget
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

// Update total when amount input changes
document.addEventListener('DOMContentLoaded', function() {
    const spentAmountInput = document.getElementById('spentAmount');
    if (spentAmountInput) {
        spentAmountInput.addEventListener('input', updateNewTotal);
    }
});

function closeEditModal() {
    document.getElementById('editSpendingModal').classList.add('hidden');
    document.getElementById('editSpendingModal').classList.remove('flex');
}

// Close modal when clicking outside
document.getElementById('editSpendingModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeEditModal();
    }
});
</script>
@endpush
@endsection
