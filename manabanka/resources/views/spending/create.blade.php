@extends('layouts.app')

@section('title', __('common.add_spending') . ' - manaBanka')

@section('content')
<div class="min-h-screen pb-20">
    <!-- Header -->
    <div class="sticky top-0 z-40 bg-slate-900/95 backdrop-blur-sm border-b border-slate-700/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <a href="{{ route('spending.index') }}" class="p-2 text-gray-400 hover:text-white transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </a>
                    <div>
                        <div class="text-sm text-gray-400">{{ __('common.add_spending') }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <form action="{{ route('spending.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Success Message -->
            @if(session('success'))
                <div class="bg-green-500/20 border border-green-500/50 rounded-lg p-4 text-green-400">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Error Messages -->
            @if($errors->any())
                <div class="bg-red-500/20 border border-red-500/50 rounded-lg p-4">
                    <ul class="list-disc list-inside text-red-400 text-sm space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Amount -->
            <div class="bg-slate-800/40 backdrop-blur-sm border border-slate-700/50 rounded-xl p-6">
                <label for="amount" class="block text-sm font-medium text-white mb-3">
                    {{ __('common.amount') }} (€)
                </label>
                <input type="number" 
                       step="0.01" 
                       min="0.01" 
                       name="amount" 
                       id="amount" 
                       value="{{ old('amount') }}"
                       class="w-full px-4 py-3 bg-slate-700/50 border border-slate-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-revolut-purple focus:border-transparent text-lg" 
                       required 
                       placeholder="0.00">
            </div>

            <!-- Category -->
            <div class="bg-slate-800/40 backdrop-blur-sm border border-slate-700/50 rounded-xl p-6">
                <label for="category" class="block text-sm font-medium text-white mb-3">
                    {{ __('common.category') }}
                </label>
                <select name="category" 
                        id="category" 
                        class="w-full px-4 py-3 bg-slate-700/50 border border-slate-600 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-revolut-purple focus:border-transparent" 
                        required>
                    <option value="">{{ __('common.select_category') }}</option>
                    <option value="housing" {{ old('category') === 'housing' ? 'selected' : '' }}>{{ __('common.category_housing') }}</option>
                    <option value="utilities" {{ old('category') === 'utilities' ? 'selected' : '' }}>{{ __('common.category_utilities') }}</option>
                    <option value="transportation" {{ old('category') === 'transportation' ? 'selected' : '' }}>{{ __('common.category_transportation') }}</option>
                    <option value="groceries" {{ old('category') === 'groceries' ? 'selected' : '' }}>{{ __('common.category_groceries') }}</option>
                    <option value="dining_out" {{ old('category') === 'dining_out' ? 'selected' : '' }}>{{ __('common.category_dining_out') }}</option>
                    <option value="shopping" {{ old('category') === 'shopping' ? 'selected' : '' }}>{{ __('common.category_shopping') }}</option>
                    <option value="entertainment" {{ old('category') === 'entertainment' ? 'selected' : '' }}>{{ __('common.category_entertainment') }}</option>
                    <option value="subscriptions" {{ old('category') === 'subscriptions' ? 'selected' : '' }}>{{ __('common.category_subscriptions') }}</option>
                    <option value="personal_care" {{ old('category') === 'personal_care' ? 'selected' : '' }}>{{ __('common.category_personal_care') }}</option>
                    <option value="loan_payments" {{ old('category') === 'loan_payments' ? 'selected' : '' }}>{{ __('common.category_loan_payments') }}</option>
                    <option value="insurance" {{ old('category') === 'insurance' ? 'selected' : '' }}>{{ __('common.category_insurance') }}</option>
                    <option value="miscellaneous" {{ old('category') === 'miscellaneous' ? 'selected' : '' }}>{{ __('common.category_miscellaneous') }}</option>
                </select>
            </div>

            <!-- Date -->
            <div class="bg-slate-800/40 backdrop-blur-sm border border-slate-700/50 rounded-xl p-6">
                <label for="date" class="block text-sm font-medium text-white mb-3">
                    {{ __('common.date') }}
                </label>
                <input type="date" 
                       name="date" 
                       id="date" 
                       value="{{ old('date', date('Y-m-d')) }}"
                       class="w-full px-4 py-3 bg-slate-700/50 border border-slate-600 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-revolut-purple focus:border-transparent" 
                       required>
            </div>

            <!-- Description -->
            <div class="bg-slate-800/40 backdrop-blur-sm border border-slate-700/50 rounded-xl p-6">
                <label for="description" class="block text-sm font-medium text-white mb-3">
                    {{ __('common.description') }} <span class="text-gray-500 text-xs">({{ __('common.optional') }})</span>
                </label>
                <input type="text" 
                       name="description" 
                       id="description" 
                       value="{{ old('description') }}"
                       class="w-full px-4 py-3 bg-slate-700/50 border border-slate-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-revolut-purple focus:border-transparent" 
                       placeholder="{{ __('common.description_placeholder') }}"
                       maxlength="255">
            </div>

            <!-- Submit Button -->
            <div class="flex space-x-4">
                <a href="{{ route('spending.index') }}" 
                   class="flex-1 px-6 py-3 bg-slate-700/50 border border-slate-600 rounded-lg text-white text-center font-medium hover:bg-slate-700 transition-colors">
                    {{ __('common.cancel') }}
                </a>
                <button type="submit" 
                        class="flex-1 px-6 py-3 bg-revolut-purple rounded-lg text-white font-medium hover:bg-revolut-purple-light transition-colors">
                    {{ __('common.add_spending') }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
