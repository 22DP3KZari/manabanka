@extends('layouts.app')

@section('title', 'Dashboard - manaBanka')

@section('content')
<div class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8 py-4 sm:py-8">
    <!-- Main Cards Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <!-- Goals Card (real data from user goals) -->
        <div class="bg-slate-800/40 backdrop-blur-sm border border-slate-700/50 rounded-xl p-5 transition-all duration-200 hover:bg-slate-800/60 hover:border-slate-600 group">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-white">{{ __('common.goals') }}</h3>
                <a href="{{ route('goals.index') }}" class="w-9 h-9 rounded-lg bg-gradient-to-br from-blue-500/20 to-blue-600/20 border border-blue-500/30 flex items-center justify-center group-hover:scale-110 transition-transform text-blue-400 hover:text-blue-300" title="{{ __('common.edit_goals') }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </a>
            </div>
            @if($emergencyFundGoal?->target_amount > 0 || $firstEtfGoal?->target_amount > 0)
                <ul class="space-y-3">
                    @if($emergencyFundGoal && (float)$emergencyFundGoal->target_amount > 0)
                        <li class="flex items-start">
                            <div class="flex-1">
                                <p class="text-sm font-medium text-white">{{ __('common.emergency_fund') }}</p>
                                <p class="text-xs text-gray-400 mt-1">€{{ number_format((float)$emergencyFundGoal->current_amount, 0, '.', '') }} / €{{ number_format((float)$emergencyFundGoal->target_amount, 0, '.', '') }}</p>
                                <div class="mt-2 w-full bg-slate-700 rounded-full h-1.5">
                                    <div class="bg-blue-500 h-1.5 rounded-full transition-all" style="width: {{ min(100, $emergencyFundGoal->progress_percent ?? 0) }}%"></div>
                                </div>
                            </div>
                        </li>
                    @endif
                    @if($firstEtfGoal && (float)$firstEtfGoal->target_amount > 0)
                        <li class="flex items-start">
                            <div class="flex-1">
                                <p class="text-sm font-medium text-white">{{ __('common.first_etf_buy') }}</p>
                                <p class="text-xs text-gray-400 mt-1">€{{ number_format((float)$firstEtfGoal->current_amount, 0, '.', '') }} / €{{ number_format((float)$firstEtfGoal->target_amount, 0, '.', '') }}</p>
                                <div class="mt-2 w-full bg-slate-700 rounded-full h-1.5">
                                    <div class="bg-revolut-purple h-1.5 rounded-full transition-all" style="width: {{ min(100, $firstEtfGoal->progress_percent ?? 0) }}%"></div>
                                </div>
                            </div>
                        </li>
                    @endif
                </ul>
                <a href="{{ route('goals.index') }}" class="mt-3 inline-flex items-center text-sm font-medium text-revolut-purple hover:text-revolut-purple-light transition-colors">
                    {{ __('common.edit_goals') }}
                    <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </a>
            @else
                <p class="text-sm text-gray-400 mb-3">{{ __('common.no_goals_yet') }}</p>
                <a href="{{ route('goals.index') }}" class="inline-flex items-center text-sm font-medium text-revolut-purple hover:text-revolut-purple-light transition-colors">
                    {{ __('common.set_your_goals') }}
                    <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </a>
            @endif
        </div>

        <!-- Budget Health Card (real data from latest budget) -->
        <div class="bg-slate-800/40 backdrop-blur-sm border border-slate-700/50 rounded-xl p-5 transition-all duration-200 hover:bg-slate-800/60 hover:border-slate-600 group">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-white">{{ __('common.budget_health') }}</h3>
                <div class="w-9 h-9 rounded-lg bg-gradient-to-br from-green-500/20 to-green-600/20 border border-green-500/30 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
            </div>
            @if(!empty($budgetHealth))
                <ul class="space-y-3">
                    @foreach($budgetHealth as $item)
                        @php
                            $statusClass = match($item['status']) {
                                'on_track' => 'text-green-400',
                                'warning' => 'text-yellow-400',
                                'over_budget' => 'text-red-400',
                                default => 'text-gray-300',
                            };
                            $statusLabel = match($item['status']) {
                                'on_track' => __('common.on_track'),
                                'warning' => __('common.budget_status_warning'),
                                'over_budget' => __('common.budget_status_over_budget'),
                                default => '',
                            };
                        @endphp
                        <li class="flex items-center justify-between">
                            <span class="text-sm text-gray-300">{{ $item['label'] }}</span>
                            <span class="text-sm font-medium {{ $statusClass }}">{{ $statusLabel }}</span>
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="text-sm text-gray-400 mb-3">{{ __('common.budget_health_no_budget') }}</p>
                <a href="{{ route('budget-planner.index') }}" class="inline-flex items-center text-sm font-medium text-revolut-purple hover:text-revolut-purple-light transition-colors">
                    {{ __('common.create_budget') }}
                    <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </a>
            @endif
        </div>

        <!-- Next Lesson Card -->
        <div class="bg-slate-800/40 backdrop-blur-sm border border-slate-700/50 rounded-xl p-5 transition-all duration-200 hover:bg-slate-800/60 hover:border-slate-600 group">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-white">{{ __('common.next_lesson') }}</h3>
                <div class="w-9 h-9 rounded-lg bg-gradient-to-br from-revolut-purple/20 to-revolut-violet/20 border border-revolut-purple/30 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <svg class="w-5 h-5 text-revolut-purple" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                </div>
            </div>
            <p class="text-sm text-gray-300 mb-4">{{ __('common.learning_etf') }}</p>
            <a href="{{ route('lessons.index') }}" class="inline-flex items-center text-sm font-medium text-revolut-purple hover:text-revolut-purple-light transition-colors">
                {{ __('common.continue_learning') }}
                <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </a>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-slate-800/40 backdrop-blur-sm border border-slate-700/50 rounded-xl p-5 transition-all duration-200 hover:bg-slate-800/60 hover:border-slate-600">
        <h2 class="text-xl font-semibold text-white mb-6">{{ __('common.quick_actions') }}</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <a href="{{ route('budgets.index') }}" class="group flex flex-col items-center justify-center p-6 rounded-lg border-2 border-slate-700/50 hover:border-revolut-purple hover:bg-slate-800/50 transition-all duration-200">
                <div class="w-12 h-12 rounded-full bg-gradient-to-br from-green-500/20 to-green-600/20 border border-green-500/30 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                </div>
                <span class="text-sm font-medium text-gray-300 group-hover:text-revolut-purple">{{ __('common.update_budget') }}</span>
            </a>
            <a href="{{ route('spending.index') }}" class="group flex flex-col items-center justify-center p-6 rounded-lg border-2 border-slate-700/50 hover:border-revolut-purple hover:bg-slate-800/50 transition-all duration-200">
                <div class="w-12 h-12 rounded-full bg-gradient-to-br from-yellow-500/20 to-yellow-600/20 border border-yellow-500/30 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path>
                    </svg>
                </div>
                <span class="text-sm font-medium text-gray-300 group-hover:text-revolut-purple">{{ __('common.nav_spending') }}</span>
            </a>
            <a href="{{ route('etf-calculator.index') }}" class="group flex flex-col items-center justify-center p-6 rounded-lg border-2 border-slate-700/50 hover:border-revolut-purple hover:bg-slate-800/50 transition-all duration-200">
                <div class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-500/20 to-blue-600/20 border border-blue-500/30 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <span class="text-sm font-medium text-gray-300 group-hover:text-revolut-purple text-center">{{ __('common.etf_calculator') }}</span>
            </a>
            <a href="{{ route('lessons.index') }}" class="group flex flex-col items-center justify-center p-6 rounded-lg border-2 border-slate-700/50 hover:border-revolut-purple hover:bg-slate-800/50 transition-all duration-200">
                <div class="w-12 h-12 rounded-full bg-gradient-to-br from-revolut-purple/20 to-revolut-violet/20 border border-revolut-purple/30 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6 text-revolut-purple" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                </div>
                <span class="text-sm font-medium text-gray-300 group-hover:text-revolut-purple text-center">{{ __('common.continue_lesson') }}</span>
            </a>
        </div>
    </div>
</div>
@endsection 