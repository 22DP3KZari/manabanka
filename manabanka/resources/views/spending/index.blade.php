@extends('layouts.app')

@section('title', __('common.spending') . ' - manaBanka')

@section('content')
<div class="min-h-screen pb-8 pb-[max(1rem,env(safe-area-inset-bottom))]">
    <!-- Header -->
    <div class="sticky top-0 z-40 bg-slate-900/95 backdrop-blur-sm border-b border-slate-700/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <button onclick="window.history.back()" class="p-2 text-gray-400 hover:text-white transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </button>
                    <div>
                        <div class="text-sm text-gray-400">{{ __('common.spending') }}</div>
                        <div class="text-xs text-gray-500">
                            @if(app()->getLocale() === 'lv')
                                {{ $startDate->format('d. F') }} – {{ $endDate->format('d. F') }}
                            @else
                                {{ $startDate->format('M d') }} – {{ $endDate->format('M d') }}
                            @endif
                        </div>
                    </div>
                </div>
                <a href="{{ route('spending.create') }}" class="p-2 text-gray-400 hover:text-white transition-colors" title="{{ __('common.add_spending') }}">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                </a>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <!-- Success Message -->
        @if(session('success'))
            <div class="bg-green-500/20 border border-green-500/50 rounded-lg p-4 mb-6 text-green-400">
                {{ session('success') }}
            </div>
        @endif

        <div class="mb-6 flex justify-center sm:justify-start">
            <div class="inline-flex rounded-lg border border-slate-700/60 bg-slate-800/60 p-1" role="tablist" aria-label="{{ __('common.spending') }}">
                <a href="{{ route('spending.index', ['period' => $period, 'tab' => 'spending']) }}"
                   class="rounded-md px-4 py-2 text-sm font-medium transition-colors {{ in_array($tab, ['spending', 'income', 'cashflow'], true) ? 'bg-revolut-purple/25 text-white' : 'text-gray-400 hover:text-white' }}">
                    {{ __('common.spending') }}
                </a>
                <a href="{{ route('spending.index', ['period' => $period, 'tab' => 'budget']) }}"
                   class="rounded-md px-4 py-2 text-sm font-medium transition-colors {{ $tab === 'budget' ? 'bg-revolut-purple/25 text-white' : 'text-gray-400 hover:text-white' }}">
                    {{ __('common.budget') }}
                </a>
            </div>
        </div>

        <!-- Donut Chart Section -->
        <div class="bg-slate-800/40 backdrop-blur-sm border border-slate-700/50 rounded-xl p-6 mb-6">
            <div class="flex flex-col items-center">
                <!-- Chart Container -->
                <div class="relative w-64 h-64 mb-6">
                    <canvas id="spendingChart"></canvas>
                    <div class="absolute inset-0 flex flex-col items-center justify-center">
                        <div class="text-sm text-gray-400 mb-1">{{ __('common.spent') }}</div>
                        <div class="text-3xl font-bold text-white">€{{ number_format($totalSpent, 2, ',', '.') }}</div>
                    </div>
                </div>

                <!-- Time Period Selector -->
                <div class="flex items-center space-x-2">
                    <a href="{{ route('spending.index', ['period' => '1w', 'tab' => $tab]) }}" 
                       class="px-4 py-2 rounded-lg text-sm font-medium transition-colors {{ $period === '1w' ? 'bg-revolut-purple/20 text-white' : 'text-gray-400 hover:text-white hover:bg-slate-700/50' }}">
                        1 {{ app()->getLocale() === 'lv' ? 'ned.' : 'week' }}
                    </a>
                    <a href="{{ route('spending.index', ['period' => '1m', 'tab' => $tab]) }}" 
                       class="px-4 py-2 rounded-lg text-sm font-medium transition-colors {{ $period === '1m' ? 'bg-revolut-purple/20 text-white' : 'text-gray-400 hover:text-white hover:bg-slate-700/50' }}">
                        1 {{ app()->getLocale() === 'lv' ? 'mēn.' : 'month' }}
                    </a>
                    <a href="{{ route('spending.index', ['period' => '6m', 'tab' => $tab]) }}" 
                       class="px-4 py-2 rounded-lg text-sm font-medium transition-colors {{ $period === '6m' ? 'bg-revolut-purple/20 text-white' : 'text-gray-400 hover:text-white hover:bg-slate-700/50' }}">
                        6 {{ app()->getLocale() === 'lv' ? 'mēn.' : 'months' }}
                    </a>
                    <a href="{{ route('spending.index', ['period' => '1y', 'tab' => $tab]) }}" 
                       class="px-4 py-2 rounded-lg text-sm font-medium transition-colors {{ $period === '1y' ? 'bg-revolut-purple/20 text-white' : 'text-gray-400 hover:text-white hover:bg-slate-700/50' }}">
                        1 {{ app()->getLocale() === 'lv' ? 'g.' : 'year' }}
                    </a>
                </div>
            </div>
        </div>

        <!-- Categories List -->
        <div class="space-y-3 scroll-list">
            @forelse($categoryData as $category => $data)
                @php
                    $categoryTranslations = [
                        'dining_out' => __('common.category_dining_out'),
                        'transportation' => __('common.category_transportation'),
                        'groceries' => __('common.category_groceries'),
                        'shopping' => __('common.category_shopping'),
                        'entertainment' => __('common.category_entertainment'),
                        'housing' => __('common.category_housing'),
                        'utilities' => __('common.category_utilities'),
                        'insurance' => __('common.category_insurance'),
                        'loan_payments' => __('common.category_loan_payments'),
                        'personal_care' => __('common.category_personal_care'),
                        'subscriptions' => __('common.category_subscriptions'),
                        'miscellaneous' => __('common.category_miscellaneous'),
                    ];
                    $categoryName = $categoryTranslations[$category] ?? ucfirst(str_replace('_', ' ', $category));
                    $categoryIcon = [
                        'dining_out' => '🍴',
                        'transportation' => '🚌',
                        'groceries' => '🛒',
                        'shopping' => '🛍️',
                        'entertainment' => '🎬',
                        'housing' => '🏠',
                        'utilities' => '💡',
                        'insurance' => '🛡️',
                        'loan_payments' => '💳',
                        'personal_care' => '💇',
                        'subscriptions' => '📱',
                        'miscellaneous' => '📦',
                    ];
                    $icon = $categoryIcon[$category] ?? '💰';
                    $color = $categoryColors[$category] ?? '#6B7280';
                @endphp
                <div class="card-solid p-4 hover:bg-slate-800/80 transition-colors">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-4 flex-1">
                            <div class="w-12 h-12 rounded-full flex items-center justify-center text-2xl" style="background-color: {{ $color }}20;">
                                {{ $icon }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="text-base font-medium text-white mb-1">{{ $categoryName }}</div>
                                @if($tab === 'budget' && isset($data['budget']))
                                    <div class="text-sm text-gray-400">
                                        {{ $data['count'] }} {{ $data['count'] === 1 ? __('common.transaction') : __('common.transactions') }}
                                        • {{ __('common.budget') }}: €{{ number_format($data['budget'], 2, ',', '.') }}
                                    </div>
                                @else
                                    <div class="text-sm text-gray-400">{{ $data['count'] }} {{ $data['count'] === 1 ? __('common.transaction') : __('common.transactions') }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="text-right ml-4">
                            <div class="text-lg font-semibold text-white mb-1">€{{ number_format($data['total'], 2, ',', '.') }}</div>
                            @if($tab === 'budget' && isset($data['budget']))
                                @php
                                    $statusColor = isset($data['status']) && $data['status'] === 'over_budget' ? 'text-red-400' : (isset($data['status']) && $data['status'] === 'warning' ? 'text-yellow-400' : 'text-green-400');
                                @endphp
                                <div class="text-sm {{ $statusColor }}">
                                    {{ isset($data['remaining']) && $data['remaining'] >= 0 ? '+' : '' }}€{{ number_format($data['remaining'] ?? 0, 2, ',', '.') }}
                                </div>
                                @if(isset($data['percentage']))
                                    <div class="text-xs text-gray-400 mt-1">{{ round($data['percentage']) }}%</div>
                                @endif
                            @else
                                <div class="text-sm text-gray-400">{{ $data['percentage'] ?? 0 }}%</div>
                            @endif
                        </div>
                    </div>
                    @if($tab === 'budget' && isset($data['budget']))
                        <!-- Progress Bar for Budget Tab -->
                        <div class="w-full bg-slate-700 rounded-full h-2 mt-3">
                            @php
                                $barColor = isset($data['status']) && $data['status'] === 'over_budget' ? 'bg-red-500' : (isset($data['status']) && $data['status'] === 'warning' ? 'bg-yellow-500' : 'bg-green-500');
                                $barWidth = min(100, $data['percentage'] ?? 0);
                            @endphp
                            <div class="{{ $barColor }} h-2 rounded-full transition-all duration-300" style="width: {{ $barWidth }}%"></div>
                        </div>
                    @endif
                    
                    @if(isset($data['transactions']) && $data['transactions']->count() > 0)
                        <!-- Transactions List -->
                        <div class="mt-4 pt-4 border-t border-slate-700/50">
                            <div class="space-y-2">
                                @foreach($data['transactions'] as $transaction)
                                    <div class="flex items-center justify-between py-2 px-3 bg-slate-700/30 rounded-lg hover:bg-slate-700/50 transition-colors">
                                        <div class="flex-1 min-w-0">
                                            <div class="text-sm font-medium text-white">
                                                €{{ number_format($transaction->amount, 2, ',', '.') }}
                                            </div>
                                            <div class="text-xs text-gray-400">
                                                {{ $transaction->date->format('d.m.Y') }}
                                                @if($transaction->description)
                                                    • {{ Str::limit($transaction->description, 30) }}
                                                @endif
                                            </div>
                                        </div>
                                        <div class="flex items-center space-x-2 ml-4">
                                            <a href="{{ route('spending.edit', $transaction) }}" 
                                               class="p-2 text-gray-400 hover:text-revolut-purple transition-colors" 
                                               title="{{ __('common.edit') }}">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </a>
                                            <form action="{{ route('spending.destroy', $transaction) }}" method="POST" class="inline" onsubmit="return confirm('{{ __('common.confirm_delete_spending') }}');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="p-2 text-gray-400 hover:text-red-400 transition-colors" 
                                                        title="{{ __('common.delete') }}">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            @empty
                <div class="bg-slate-800/40 backdrop-blur-sm border border-slate-700/50 rounded-xl p-8 text-center">
                    <div class="text-gray-400 mb-2">
                        @if($tab === 'budget')
                            {{ __('common.no_budgets') }}
                        @else
                            {{ __('common.no_spending_data') }}
                        @endif
                    </div>
                    <div class="text-sm text-gray-500">
                        @if($tab === 'budget')
                            <a href="{{ route('budget-planner.index') }}" class="text-revolut-purple hover:text-revolut-purple-light">{{ __('common.create_first_budget') }}</a>
                        @else
                            <a href="{{ route('spending.create') }}" class="text-revolut-purple hover:text-revolut-purple-light">{{ __('common.add_spending') }}</a>
                        @endif
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('spendingChart');
    if (!ctx) return;

    const categoryData = @json($chartCategoryData ?? []);
    const categoryColors = @json($categoryColors);
    
    const labels = [];
    const data = [];
    const colors = [];
    const backgroundColors = [];

    Object.keys(categoryData).forEach(category => {
        const categoryTranslations = {
            'dining_out': '{{ __('common.category_dining_out') }}',
            'transportation': '{{ __('common.category_transportation') }}',
            'groceries': '{{ __('common.category_groceries') }}',
            'shopping': '{{ __('common.category_shopping') }}',
            'entertainment': '{{ __('common.category_entertainment') }}',
            'housing': '{{ __('common.category_housing') }}',
            'utilities': '{{ __('common.category_utilities') }}',
            'insurance': '{{ __('common.category_insurance') }}',
            'loan_payments': '{{ __('common.category_loan_payments') }}',
            'personal_care': '{{ __('common.category_personal_care') }}',
            'subscriptions': '{{ __('common.category_subscriptions') }}',
            'miscellaneous': '{{ __('common.category_miscellaneous') }}',
        };
        
        labels.push(categoryTranslations[category] || category);
        data.push(Math.abs(categoryData[category].total));
        const color = categoryColors[category] || '#6B7280';
        colors.push(color);
        backgroundColors.push(color + '80');
    });

    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: labels,
            datasets: [{
                data: data,
                backgroundColor: colors,
                borderWidth: 0,
                cutout: '70%'
            }]
        },
        options: {
            animation: { duration: 0 },
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    enabled: true,
                    callbacks: {
                        label: function(context) {
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = ((context.parsed / total) * 100).toFixed(1);
                            return context.label + ': €' + context.parsed.toFixed(2) + ' (' + percentage + '%)';
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
