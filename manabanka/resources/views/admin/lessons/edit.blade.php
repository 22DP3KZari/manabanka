@extends('layouts.admin')

@section('title', 'Edit: ' . $lesson->title)

@section('content')
    <div class="mb-6">
        <h1 class="text-xl font-semibold text-white">{{ __('common.admin_edit_latvian_translation') }}</h1>
        <p class="mt-1 text-sm text-gray-400">{{ $lesson->title }}</p>
    </div>

    <form action="{{ route('admin.lessons.update', $lesson) }}" method="POST" class="bg-slate-800/40 backdrop-blur-sm border border-slate-700/50 rounded-xl overflow-hidden">
        @csrf
        @method('PUT')

        <div class="p-4 sm:p-6 space-y-6">
            <!-- English reference -->
            <div class="p-4 rounded-xl bg-slate-900/60 border border-slate-700/50">
                <h3 class="text-base font-semibold text-gray-300 mb-4">{{ __('common.admin_english_reference') }}</h3>
                <div class="space-y-4 text-sm">
                    <div>
                        <p class="text-xs font-medium text-gray-400 uppercase tracking-wider mb-1">{{ __('common.admin_english_title') }}</p>
                        <p class="text-white">{{ $lesson->title }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-gray-400 uppercase tracking-wider mb-1">{{ __('common.description') }}</p>
                        <p class="text-gray-300 whitespace-pre-wrap">{{ $lesson->description }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-gray-400 uppercase tracking-wider mb-1">{{ __('common.admin_content') }}</p>
                        <div class="text-gray-300 whitespace-pre-wrap max-h-80 overflow-y-auto">{{ $lesson->content }}</div>
                    </div>
                </div>
            </div>

            <!-- Latvian fields -->
            <div class="space-y-4">
                <div>
                    <label for="title_lv" class="block text-sm font-medium text-gray-300 mb-2">{{ __('common.admin_latvian_title') }} <span class="text-red-400">*</span></label>
                    <input type="text" id="title_lv" name="title_lv" value="{{ old('title_lv', $lesson->title_lv) }}" required
                           class="w-full px-4 py-2.5 rounded-lg bg-slate-900/80 border border-slate-600 text-white placeholder-gray-500 focus:ring-2 focus:ring-revolut-purple/50 focus:border-revolut-purple/50">
                    @error('title_lv')<p class="mt-1 text-sm text-red-400">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="description_lv" class="block text-sm font-medium text-gray-300 mb-2">{{ __('common.admin_latvian_description') }}</label>
                    <textarea id="description_lv" name="description_lv" rows="3"
                              class="w-full px-4 py-2.5 rounded-lg bg-slate-900/80 border border-slate-600 text-white placeholder-gray-500 focus:ring-2 focus:ring-revolut-purple/50 focus:border-revolut-purple/50">{{ old('description_lv', $lesson->description_lv) }}</textarea>
                    @error('description_lv')<p class="mt-1 text-sm text-red-400">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="content_lv" class="block text-sm font-medium text-gray-300 mb-2">{{ __('common.admin_latvian_content') }} <span class="text-red-400">*</span></label>
                    <textarea id="content_lv" name="content_lv" rows="18"
                              class="w-full px-4 py-2.5 rounded-lg bg-slate-900/80 border border-slate-600 text-white placeholder-gray-500 focus:ring-2 focus:ring-revolut-purple/50 focus:border-revolut-purple/50 font-mono text-sm">{{ old('content_lv', $lesson->content_lv) }}</textarea>
                    <p class="mt-1 text-xs text-gray-500">{{ __('common.admin_line_breaks_preserved') }}</p>
                    @error('content_lv')<p class="mt-1 text-sm text-red-400">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="flex flex-wrap items-center justify-end gap-3 pt-2">
                <a href="{{ route('admin.lessons.index') }}" class="px-4 py-2 rounded-lg text-sm font-medium bg-slate-700/80 text-white border border-slate-600 hover:bg-slate-700 transition-colors">{{ __('common.cancel') }}</a>
                <button type="submit" class="px-5 py-2 rounded-lg text-sm font-medium bg-revolut-purple text-white hover:bg-revolut-purple-dark transition-colors">{{ __('common.admin_save_translation') }}</button>
            </div>
        </div>
    </form>
@endsection
