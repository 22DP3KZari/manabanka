@extends('layouts.app')

@section('title', __('common.goals') . ' - manaBanka')

@section('content')
<div class="max-w-2xl mx-auto px-3 sm:px-6 lg:px-8 py-4 sm:py-8">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-white mb-2">{{ __('common.set_your_goals') }}</h1>
        <p class="text-gray-400">{{ __('common.set_goals_subtitle') }}</p>
    </div>

    @if (session('success'))
        <div class="mb-6 bg-green-500/20 border border-green-500/50 rounded-lg p-3">
            <p class="text-sm text-green-300">{{ session('success') }}</p>
        </div>
    @endif

    @if ($errors->any())
        <div class="mb-6 bg-red-500/20 border border-red-500/50 rounded-lg p-3">
            <ul class="text-sm text-red-300 list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('goals.store') }}" method="POST" class="space-y-6">
        @csrf

        <!-- Emergency fund -->
        <div class="bg-slate-800/40 backdrop-blur-sm border border-slate-700/50 rounded-xl p-6">
            <h2 class="text-lg font-semibold text-white mb-4">{{ __('common.emergency_fund') }}</h2>
            <p class="text-sm text-gray-400 mb-4">{{ __('common.emergency_fund_help') }}</p>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="emergency_fund_target" class="block text-sm font-medium text-gray-300 mb-2">{{ __('common.goal_target') }} (€)</label>
                    <input type="number" step="0.01" min="0" name="emergency_fund_target" id="emergency_fund_target"
                           class="w-full px-4 py-3 bg-slate-700/50 border border-slate-600 rounded-lg text-white placeholder-gray-500 focus:ring-2 focus:ring-revolut-purple focus:border-transparent"
                           placeholder="e.g. 1000"
                           value="{{ old('emergency_fund_target', $emergencyFund?->target_amount) }}">
                </div>
                <div>
                    <label for="emergency_fund_current" class="block text-sm font-medium text-gray-300 mb-2">{{ __('common.goal_saved') }} (€)</label>
                    <input type="number" step="0.01" min="0" name="emergency_fund_current" id="emergency_fund_current"
                           class="w-full px-4 py-3 bg-slate-700/50 border border-slate-600 rounded-lg text-white placeholder-gray-500 focus:ring-2 focus:ring-revolut-purple focus:border-transparent"
                           placeholder="e.g. 450"
                           value="{{ old('emergency_fund_current', $emergencyFund?->current_amount) }}">
                </div>
            </div>
        </div>

        <!-- First ETF buy -->
        <div class="bg-slate-800/40 backdrop-blur-sm border border-slate-700/50 rounded-xl p-6">
            <h2 class="text-lg font-semibold text-white mb-4">{{ __('common.first_etf_buy') }}</h2>
            <p class="text-sm text-gray-400 mb-4">{{ __('common.first_etf_buy_help') }}</p>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="first_etf_buy_target" class="block text-sm font-medium text-gray-300 mb-2">{{ __('common.goal_target') }} (€)</label>
                    <input type="number" step="0.01" min="0" name="first_etf_buy_target" id="first_etf_buy_target"
                           class="w-full px-4 py-3 bg-slate-700/50 border border-slate-600 rounded-lg text-white placeholder-gray-500 focus:ring-2 focus:ring-revolut-purple focus:border-transparent"
                           placeholder="e.g. 50"
                           value="{{ old('first_etf_buy_target', $firstEtfBuy?->target_amount) }}">
                </div>
                <div>
                    <label for="first_etf_buy_current" class="block text-sm font-medium text-gray-300 mb-2">{{ __('common.goal_saved') }} (€)</label>
                    <input type="number" step="0.01" min="0" name="first_etf_buy_current" id="first_etf_buy_current"
                           class="w-full px-4 py-3 bg-slate-700/50 border border-slate-600 rounded-lg text-white placeholder-gray-500 focus:ring-2 focus:ring-revolut-purple focus:border-transparent"
                           placeholder="e.g. 0"
                           value="{{ old('first_etf_buy_current', $firstEtfBuy?->current_amount) }}">
                </div>
            </div>
        </div>

        <div class="flex flex-col sm:flex-row gap-3">
            <button type="submit" class="px-6 py-3 bg-revolut-purple hover:bg-revolut-purple-dark text-white font-medium rounded-lg transition-colors">
                {{ __('common.save_goals') }}
            </button>
            <a href="{{ route('dashboard') }}" class="px-6 py-3 bg-slate-700/80 hover:bg-slate-700 text-white font-medium rounded-lg transition-colors text-center">
                {{ __('common.cancel') }}
            </a>
        </div>
    </form>
</div>
@endsection
