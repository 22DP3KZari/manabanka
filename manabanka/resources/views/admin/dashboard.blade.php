@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <!-- Statistics -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
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
        <div class="bg-slate-800/40 backdrop-blur-sm border border-slate-700/50 rounded-xl p-5 transition-all duration-200 hover:bg-slate-800/60 hover:border-slate-600 group">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-400">{{ __('common.admin_total_volume') }}</p>
                    <p class="mt-1 text-2xl sm:text-3xl font-semibold text-white">€{{ number_format($stats['total_volume'], 2) }}</p>
                </div>
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-revolut-purple/20 to-revolut-violet/20 border border-revolut-purple/30 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <svg class="w-5 h-5 text-revolut-purple" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-1 gap-6">
        <!-- Recent Transactions -->
        <div class="bg-slate-800/40 backdrop-blur-sm border border-slate-700/50 rounded-xl overflow-hidden">
            <div class="px-4 py-4 sm:px-6 sm:py-5 border-b border-slate-700/50">
                <h3 class="text-lg font-semibold text-white">{{ __('common.admin_recent_transactions') }}</h3>
            </div>
            <div class="px-4 py-4 sm:px-6 sm:py-5">
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
            </div>
        </div>
    </div>

    <!-- Daily Transaction Stats -->
    <div class="mt-6 bg-slate-800/40 backdrop-blur-sm border border-slate-700/50 rounded-xl overflow-hidden">
        <div class="px-4 py-4 sm:px-6 sm:py-5 border-b border-slate-700/50">
            <h3 class="text-lg font-semibold text-white">{{ __('common.admin_daily_stats') }}</h3>
        </div>
        <div class="px-4 py-4 sm:px-6 sm:py-5">
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
        </div>
    </div>
@endsection
