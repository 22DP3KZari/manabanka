@extends('layouts.admin')

@section('title', 'Lesson Translations')

@section('content')
    <div class="mb-6">
        <h1 class="text-xl font-semibold text-white">{{ __('common.admin_edit_lesson_translations') }}</h1>
        <p class="mt-1 text-sm text-gray-400">{{ __('common.admin_lesson_translations_subtitle') }}</p>
    </div>

    @if(session('success'))
        <div class="mb-6 rounded-xl bg-green-500/20 border border-green-500/30 text-green-300 px-4 py-3">{{ session('success') }}</div>
    @endif

    @foreach($lessons as $categoryKey => $categoryLessons)
        <div class="mb-8">
            <h2 class="text-lg font-semibold text-white mb-4">{{ $categories[$categoryKey] ?? ucfirst($categoryKey) }}</h2>
            <div class="bg-slate-800/40 backdrop-blur-sm border border-slate-700/50 rounded-xl overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-700/50">
                        <thead>
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider sm:px-6">{{ __('common.admin_lesson') }}</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">{{ __('common.admin_english_title') }}</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">{{ __('common.admin_latvian_title') }}</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">{{ __('common.admin_status') }}</th>
                                <th class="px-4 py-3 text-right text-xs font-semibold text-gray-400 uppercase tracking-wider sm:pr-6">{{ __('common.admin_actions') }}</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-700/50">
                            @foreach($categoryLessons as $lesson)
                            <tr class="hover:bg-slate-800/40 transition-colors">
                                <td class="px-4 py-4 whitespace-nowrap text-sm text-white sm:px-6">{{ $lesson->order }}</td>
                                <td class="px-4 py-4 text-sm text-gray-300">{{ $lesson->title }}</td>
                                <td class="px-4 py-4 text-sm">
                                    @if($lesson->title_lv)
                                        <span class="text-gray-300">{{ $lesson->title_lv }}</span>
                                    @else
                                        <span class="text-red-400">{{ __('common.admin_not_translated') }}</span>
                                    @endif
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    @if($lesson->title_lv && $lesson->description_lv && $lesson->content_lv)
                                        <span class="inline-flex rounded-full px-2.5 py-0.5 text-xs font-medium bg-green-500/20 text-green-400 border border-green-500/30">{{ __('common.admin_complete') }}</span>
                                    @elseif($lesson->title_lv || $lesson->description_lv || $lesson->content_lv)
                                        <span class="inline-flex rounded-full px-2.5 py-0.5 text-xs font-medium bg-yellow-500/20 text-yellow-400 border border-yellow-500/30">{{ __('common.admin_partial') }}</span>
                                    @else
                                        <span class="inline-flex rounded-full px-2.5 py-0.5 text-xs font-medium bg-red-500/20 text-red-400 border border-red-500/30">{{ __('common.admin_missing') }}</span>
                                    @endif
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap text-right text-sm font-medium sm:pr-6">
                                    <a href="{{ route('admin.lessons.edit', $lesson) }}" class="text-revolut-purple hover:text-revolut-purple-light transition-colors">{{ __('common.edit') }}</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endforeach
@endsection
