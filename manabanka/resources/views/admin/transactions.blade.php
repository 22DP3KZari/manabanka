@extends('layouts.admin')

@section('title', __('common.admin_transactions_title'))

@section('content')
    <div class="mb-4 sm:mb-6">
        <h1 class="text-lg sm:text-xl font-semibold text-white">{{ __('common.admin_transactions_title') }}</h1>
        <p class="mt-1 text-xs sm:text-sm text-gray-400">{{ __('common.admin_transactions_subtitle') }}</p>
    </div>

    <div class="bg-slate-800/40 backdrop-blur-sm border border-slate-700/50 rounded-xl overflow-hidden">
        <!-- Desktop: table -->
        <div class="hidden md:block">
            <table class="min-w-full divide-y divide-slate-700/50">
                <thead>
                    <tr>
                        <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider sm:pl-6">{{ __('common.admin_user') }}</th>
                        <th scope="col" class="px-3 py-3.5 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">{{ __('common.category') }}</th>
                        <th scope="col" class="px-3 py-3.5 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">{{ __('common.amount') }}</th>
                        <th scope="col" class="px-3 py-3.5 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">{{ __('common.description') }}</th>
                        <th scope="col" class="px-3 py-3.5 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">{{ __('common.date') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-700/50">
                    @foreach($transactions as $transaction)
                    <tr class="hover:bg-slate-800/40 transition-colors">
                        <td class="whitespace-nowrap py-4 pl-4 text-sm font-medium text-white sm:pl-6">{{ $transaction->user->name }}</td>
                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-400">{{ __('common.category_' . $transaction->category) }}</td>
                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-400">€{{ number_format($transaction->amount, 2) }}</td>
                        <td class="px-3 py-4 text-sm text-gray-400 max-w-xs truncate">{{ $transaction->description ?? __('common.admin_no_description') }}</td>
                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-400">{{ $transaction->created_at->format('M d, Y H:i') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Mobile: cards -->
        <div class="md:hidden divide-y divide-slate-700/50">
            @foreach($transactions as $transaction)
            <div class="p-4 active:bg-slate-800/40 transition-colors">
                <div class="flex justify-between items-start gap-3">
                    <div class="min-w-0 flex-1">
                        <p class="text-sm font-medium text-white truncate">{{ $transaction->user->name }}</p>
                        <p class="text-xs text-gray-400 truncate mt-0.5">{{ __('common.category_' . $transaction->category) }}</p>
                        <p class="text-xs text-gray-500 mt-1 truncate">{{ $transaction->description ?? __('common.admin_no_description') }}</p>
                        <p class="text-xs text-gray-500 mt-1">{{ $transaction->created_at->format('M d, Y H:i') }}</p>
                    </div>
                    <span class="text-sm font-semibold text-gray-300 shrink-0">€{{ number_format($transaction->amount, 2) }}</span>
                </div>
            </div>
            @endforeach
        </div>

        <div class="px-4 py-3 sm:px-6 border-t border-slate-700/50">
            {{ $transactions->links() }}
        </div>
    </div>
@endsection
