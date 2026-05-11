@extends('layouts.app')

@section('title', __('common.lessons') ?? 'Lessons - manaBanka')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-white mb-2">{{ __('common.lessons') ?? 'Lessons' }}</h1>
        <p class="text-gray-400">{{ __('common.lessons_subtitle') ?? 'Learn the basics of investing, ETFs, and financial planning' }}</p>
    </div>

    <!-- Category Filter -->
    <div class="mb-6 flex flex-wrap gap-2">
        <a href="{{ route('lessons.index') }}" 
           class="px-4 py-2 rounded-lg transition-colors {{ !$category ? 'bg-revolut-purple text-white' : 'bg-slate-800/40 text-gray-300 hover:bg-slate-800/60' }}">
            {{ __('common.all_categories') ?? 'All Categories' }}
        </a>
        @foreach($categories as $catKey => $catName)
            <a href="{{ route('lessons.index', ['category' => $catKey]) }}" 
               class="px-4 py-2 rounded-lg transition-colors {{ $category === $catKey ? 'bg-revolut-purple text-white' : 'bg-slate-800/40 text-gray-300 hover:bg-slate-800/60' }}">
                {{ $catName }}
            </a>
        @endforeach
    </div>

    <!-- Lessons by Category -->
    @forelse($lessons as $categoryKey => $categoryLessons)
        <div class="mb-8">
            <h2 class="text-2xl font-semibold text-white mb-4">
                {{ $categories[$categoryKey] ?? ucfirst($categoryKey) }}
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 scroll-list">
                @foreach($categoryLessons as $lesson)
                    @php
                        $progress = $userProgress[$lesson->id] ?? ['completed' => false, 'progress_percentage' => 0];
                    @endphp
                    <a href="{{ route('lessons.show', $lesson->slug) }}" 
                       class="card-solid p-5 hover:bg-slate-800/80 hover:border-revolut-purple/50 transition-colors border group">
                        <div class="flex items-start justify-between mb-3">
                            <div class="flex-1">
                                <h3 class="text-lg font-semibold text-white mb-2 group-hover:text-revolut-purple transition-colors">
                                    {{ $lesson->localized_title ?? $lesson->title }}
                                </h3>
                                @if($lesson->localized_description ?? $lesson->description)
                                    <p class="text-sm text-gray-400 mb-2 line-clamp-2">{{ $lesson->localized_description ?? $lesson->description }}</p>
                                @endif
                            </div>
                            @if($progress['completed'])
                                <div class="ml-2 flex-shrink-0">
                                    <svg class="w-6 h-6 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                            @endif
                        </div>
                        
                        <div class="flex items-center justify-between text-xs text-gray-400">
                            <div class="flex items-center space-x-3">
                                @if($lesson->duration_minutes)
                                    <span class="flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        {{ $lesson->duration_minutes }} {{ __('common.min') ?? 'min' }}
                                    </span>
                                @endif
                                <span class="px-2 py-1 rounded bg-slate-700/50 text-gray-300">
                                    {{ __('common.difficulty_' . $lesson->difficulty) !== 'common.difficulty_' . $lesson->difficulty ? __('common.difficulty_' . $lesson->difficulty) : ucfirst($lesson->difficulty) }}
                                </span>
                            </div>
                        </div>
                        
                        @if($progress['progress_percentage'] > 0 && !$progress['completed'])
                            <div class="mt-3">
                                <div class="w-full bg-slate-700 rounded-full h-2">
                                    <div class="bg-revolut-purple h-2 rounded-full transition-all" style="width: {{ $progress['progress_percentage'] }}%"></div>
                                </div>
                                <p class="text-xs text-gray-400 mt-1">{{ $progress['progress_percentage'] }}% {{ __('common.complete') ?? 'complete' }}</p>
                            </div>
                        @endif
                    </a>
                @endforeach
            </div>
        </div>
    @empty
        <div class="bg-slate-800/40 backdrop-blur-sm border border-slate-700/50 rounded-xl p-8 text-center">
            <p class="text-gray-400">{{ __('common.no_lessons_found') ?? 'No lessons found in this category.' }}</p>
        </div>
    @endforelse
</div>
@endsection
