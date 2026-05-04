@extends('layouts.admin')

@section('title', __('common.admin_nav_dashboard'))

@section('content')
    <div class="mb-4 sm:mb-6">
        <h1 class="text-lg sm:text-xl font-semibold text-white">{{ __('common.admin_nav_dashboard') }}</h1>
        <p class="mt-1 text-xs sm:text-sm text-gray-400">{{ __('common.admin_transactions_subtitle') }}</p>
    </div>

    <!-- Statistics -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8 max-w-3xl">
        <div class="bg-slate-800/40 backdrop-blur-sm border border-slate-700/50 rounded-xl p-5 transition-all duration-200 hover:bg-slate-800/60 hover:border-slate-600 group">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-400">{{ __('common.admin_total_users') }}</p>
                    <p class="mt-1 text-2xl sm:text-3xl font-semibold text-white">{{ $stats['total_users'] }}</p>
                </div>
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-500/20 to-blue-600/20 border border-blue-500/30 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                </div>
            </div>
        </div>
        <div class="bg-slate-800/40 backdrop-blur-sm border border-slate-700/50 rounded-xl p-5 transition-all duration-200 hover:bg-slate-800/60 hover:border-slate-600 group">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-400">{{ __('common.admin_total_transactions') }}</p>
                    <p class="mt-1 text-2xl sm:text-3xl font-semibold text-white">{{ $stats['total_transactions'] }}</p>
                </div>
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-green-500/20 to-green-600/20 border border-green-500/30 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick actions -->
    <div class="mb-8">
        <h2 class="text-xs font-semibold uppercase tracking-wider text-gray-500 mb-3">{{ __('common.admin_quick_actions_title') }}</h2>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <a href="{{ route('admin.users') }}" class="group relative flex flex-col rounded-xl border border-slate-700/50 bg-slate-800/30 p-4 sm:p-5 transition-all duration-200 hover:border-blue-500/40 hover:bg-slate-800/55 hover:shadow-lg hover:shadow-blue-900/20 hover:-translate-y-0.5 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500/60 focus-visible:ring-offset-2 focus-visible:ring-offset-slate-900">
                <div class="flex items-start justify-between gap-3">
                    <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-gradient-to-br from-blue-500/25 to-blue-600/10 border border-blue-500/30 text-blue-400 group-hover:scale-105 transition-transform">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    </div>
                    <span class="inline-flex items-center rounded-full border border-blue-500/30 bg-blue-500/10 px-2.5 py-0.5 text-xs font-semibold text-blue-200 tabular-nums">{{ $stats['total_users'] }}</span>
                </div>
                <p class="mt-4 text-base font-semibold text-white">{{ __('common.admin_nav_users') }}</p>
                <p class="mt-1 text-sm text-gray-400 line-clamp-2">{{ __('common.admin_quick_action_users_hint') }}</p>
                <span class="mt-4 inline-flex items-center gap-1 text-sm font-medium text-blue-400 group-hover:text-blue-300">
                    {{ __('common.admin_quick_action_open') }}
                    <svg class="h-4 w-4 transition-transform group-hover:translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </span>
            </a>
            <a href="{{ route('admin.transactions') }}" class="group relative flex flex-col rounded-xl border border-slate-700/50 bg-slate-800/30 p-4 sm:p-5 transition-all duration-200 hover:border-emerald-500/40 hover:bg-slate-800/55 hover:shadow-lg hover:shadow-emerald-900/15 hover:-translate-y-0.5 focus:outline-none focus-visible:ring-2 focus-visible:ring-emerald-500/60 focus-visible:ring-offset-2 focus-visible:ring-offset-slate-900">
                <div class="flex items-start justify-between gap-3">
                    <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-gradient-to-br from-emerald-500/25 to-emerald-600/10 border border-emerald-500/30 text-emerald-400 group-hover:scale-105 transition-transform">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                    </div>
                    <span class="inline-flex items-center rounded-full border border-emerald-500/30 bg-emerald-500/10 px-2.5 py-0.5 text-xs font-semibold text-emerald-200 tabular-nums">{{ $stats['total_transactions'] }}</span>
                </div>
                <p class="mt-4 text-base font-semibold text-white">{{ __('common.admin_nav_transactions') }}</p>
                <p class="mt-1 text-sm text-gray-400 line-clamp-2">{{ __('common.admin_quick_action_transactions_hint') }}</p>
                <span class="mt-4 inline-flex items-center gap-1 text-sm font-medium text-emerald-400 group-hover:text-emerald-300">
                    {{ __('common.admin_quick_action_open') }}
                    <svg class="h-4 w-4 transition-transform group-hover:translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </span>
            </a>
            <a href="{{ route('admin.lessons.index') }}" class="group relative flex flex-col rounded-xl border border-slate-700/50 bg-slate-800/30 p-4 sm:p-5 transition-all duration-200 hover:border-violet-500/40 hover:bg-slate-800/55 hover:shadow-lg hover:shadow-violet-900/20 hover:-translate-y-0.5 focus:outline-none focus-visible:ring-2 focus-visible:ring-violet-500/60 focus-visible:ring-offset-2 focus-visible:ring-offset-slate-900">
                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-gradient-to-br from-violet-500/25 to-violet-600/10 border border-violet-500/30 text-violet-400 group-hover:scale-105 transition-transform">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1 5H6a2 2 0 00-2 2v8a2 2 0 002 2h8a2 2 0 002-2V9a2 2 0 00-2-2h-2M9 12h6m-6 4h6"/></svg>
                </div>
                <p class="mt-4 text-base font-semibold text-white">{{ __('common.admin_nav_lesson_translations') }}</p>
                <p class="mt-1 text-sm text-gray-400 line-clamp-2">{{ __('common.admin_quick_action_lessons_hint') }}</p>
                <span class="mt-4 inline-flex items-center gap-1 text-sm font-medium text-violet-400 group-hover:text-violet-300">
                    {{ __('common.admin_quick_action_open') }}
                    <svg class="h-4 w-4 transition-transform group-hover:translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </span>
            </a>
        </div>
    </div>

    @if($stats['recent_transactions']->isEmpty() && $stats['daily_transactions']->isEmpty())
        <div class="bg-slate-800/40 backdrop-blur-sm border border-slate-700/50 rounded-xl p-6 sm:p-8 text-center">
            <p class="text-sm sm:text-base text-gray-300 mb-2">{{ __('common.admin_no_transactions_yet') }}</p>
            <p class="text-xs sm:text-sm text-gray-500 mb-6">{{ __('common.admin_transactions_subtitle') }}</p>
            <div class="flex flex-col sm:flex-row justify-center gap-3">
                <a href="{{ route('admin.users') }}" class="inline-flex items-center justify-center px-4 py-2.5 rounded-lg border border-slate-600 text-gray-200 hover:bg-slate-700/50 transition-colors">
                    {{ __('common.admin_nav_users') }}
                </a>
                <a href="{{ route('admin.transactions') }}" class="inline-flex items-center justify-center px-4 py-2.5 rounded-lg bg-revolut-purple text-white hover:bg-revolut-purple-dark transition-colors">
                    {{ __('common.admin_nav_transactions') }}
                </a>
            </div>
        </div>
    @else
        <div class="grid grid-cols-1 lg:grid-cols-1 gap-6">
            <!-- Recent Transactions -->
            <div class="bg-slate-800/40 backdrop-blur-sm border border-slate-700/50 rounded-xl overflow-hidden">
                <div class="px-4 py-4 sm:px-6 sm:py-5 border-b border-slate-700/50">
                    <h3 class="text-lg font-semibold text-white">{{ __('common.admin_recent_transactions') }}</h3>
                </div>
                <div class="px-4 py-4 sm:px-6 sm:py-5">
                    @if($stats['recent_transactions']->isNotEmpty())
                        <ul class="divide-y divide-slate-700/50">
                            @foreach($stats['recent_transactions'] as $transaction)
                            <li class="py-4 first:pt-0 last:pb-0">
                                <div class="flex items-center justify-between gap-4">
                                    <div class="min-w-0 flex-1">
                                        <p class="text-sm font-medium text-white truncate">{{ $transaction->user->name }}</p>
                                        <p class="text-sm text-gray-400 truncate">{{ $transaction->description ?? __('common.admin_no_description') }}</p>
                                    </div>
                                    <span class="text-sm font-medium text-gray-300 shrink-0">€{{ number_format($transaction->amount, 2) }}</span>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-sm text-gray-400">{{ __('common.admin_no_transactions_yet') }}</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Daily Transaction Stats -->
        <div class="mt-6 bg-slate-800/40 backdrop-blur-sm border border-slate-700/50 rounded-xl overflow-hidden">
            <div class="px-4 py-4 sm:px-6 sm:py-5 border-b border-slate-700/50">
                <h3 class="text-lg font-semibold text-white">{{ __('common.admin_daily_stats') }}</h3>
            </div>
            <div class="px-4 py-4 sm:px-6 sm:py-5">
                @if($stats['daily_transactions']->isNotEmpty())
                    <ul class="divide-y divide-slate-700/50">
                        @foreach($stats['daily_transactions'] as $stat)
                        <li class="py-4 first:pt-0 last:pb-0">
                            <div class="flex flex-wrap items-center justify-between gap-2">
                                <span class="text-sm font-medium text-white">{{ \Carbon\Carbon::parse($stat->date)->format('F j, Y') }}</span>
                                <span class="text-sm text-gray-400">{{ __('common.admin_transactions_count', ['count' => $stat->count]) }}</span>
                                <span class="text-sm font-medium text-gray-300">€{{ number_format($stat->total, 2) }}</span>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-sm text-gray-400">{{ __('common.admin_no_transactions_yet') }}</p>
                @endif
            </div>
        </div>
    @endif
@endsection
