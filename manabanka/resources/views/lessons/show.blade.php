@extends('layouts.app')

@section('title', ($lesson->localized_title ?? $lesson->title) . ' - manaBanka')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Breadcrumb -->
    <nav class="mb-6 text-sm text-gray-400">
        <a href="{{ route('lessons.index') }}" class="hover:text-white transition-colors">{{ __('common.lessons') ?? 'Lessons' }}</a>
        <span class="mx-2">/</span>
        <a href="{{ route('lessons.index', ['category' => $lesson->category]) }}" class="hover:text-white transition-colors">
            {{ $categories[$lesson->category] ?? ucfirst($lesson->category) }}
        </a>
        <span class="mx-2">/</span>
        <span class="text-white">{{ $lesson->localized_title ?? $lesson->title }}</span>
    </nav>

    <!-- Lesson Header -->
    <div class="bg-slate-800/40 backdrop-blur-sm border border-slate-700/50 rounded-xl p-6 mb-6">
        <div class="flex items-start justify-between mb-4">
            <div class="flex-1">
                <h1 class="text-3xl font-bold text-white mb-3">{{ $lesson->localized_title ?? $lesson->title }}</h1>
                @if($lesson->localized_description ?? $lesson->description)
                    <p class="text-gray-400 text-lg mb-4">{{ $lesson->localized_description ?? $lesson->description }}</p>
                @endif
            </div>
            @if($userProgress && $userProgress->completed)
                <div class="ml-4 flex-shrink-0">
                    <div class="w-12 h-12 rounded-full bg-green-500/20 border border-green-500/30 flex items-center justify-center">
                        <svg class="w-6 h-6 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                </div>
            @endif
        </div>
        
        <div class="flex flex-wrap items-center gap-4 text-sm text-gray-400">
            @if($lesson->duration_minutes)
                <span class="flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    {{ $lesson->duration_minutes }} {{ __('common.minutes') ?? 'minutes' }}
                </span>
            @endif
            <span class="px-3 py-1 rounded-full bg-slate-700/50 text-gray-300">
                {{ __('common.difficulty_' . $lesson->difficulty) !== 'common.difficulty_' . $lesson->difficulty ? __('common.difficulty_' . $lesson->difficulty) : ucfirst($lesson->difficulty) }}
            </span>
            @if($userProgress)
                <span class="px-3 py-1 rounded-full bg-revolut-purple/20 text-revolut-purple">
                    {{ $userProgress->progress_percentage }}% {{ __('common.complete') ?? 'complete' }}
                </span>
            @endif
        </div>
    </div>

    <!-- Lesson Content -->
    <div class="bg-slate-800/40 backdrop-blur-sm border border-slate-700/50 rounded-xl p-6 mb-6">
        <div class="prose prose-invert max-w-none">
            {!! nl2br(e($lesson->localized_content ?? $lesson->content)) !!}
        </div>
    </div>

    <!-- Progress Tracking -->
    @auth
        @if($userProgress && !$userProgress->completed)
            <div class="bg-slate-800/40 backdrop-blur-sm border border-slate-700/50 rounded-xl p-6 mb-6">
                <div class="mb-4">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm font-medium text-gray-300">{{ __('common.progress') ?? 'Progress' }}</span>
                        <span class="text-sm text-gray-400">{{ $userProgress->progress_percentage }}%</span>
                    </div>
                    <div class="w-full bg-slate-700 rounded-full h-2">
                        <div class="bg-revolut-purple h-2 rounded-full transition-all" style="width: {{ $userProgress->progress_percentage }}%"></div>
                    </div>
                </div>
                <form action="{{ route('lessons.complete', $lesson->slug) }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="w-full bg-revolut-purple hover:bg-revolut-purple-dark text-white font-medium px-6 py-3 rounded-lg transition-colors">
                        {{ __('common.mark_as_complete') ?? 'Mark as Complete' }}
                    </button>
                </form>
            </div>
        @elseif($userProgress && $userProgress->completed)
            <div class="bg-green-500/20 border border-green-500/30 rounded-xl p-6 mb-6">
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-green-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <p class="text-green-400 font-medium">{{ __('common.lesson_completed') ?? 'Lesson completed!' }}</p>
                </div>
            </div>
        @endif
    @endauth

    <!-- Navigation -->
    <div class="flex items-center justify-between">
        @if($prevLesson)
            <a href="{{ route('lessons.show', $prevLesson->slug) }}" 
               class="flex items-center text-gray-400 hover:text-white transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                <span>{{ __('common.previous_lesson') ?? 'Previous Lesson' }}</span>
            </a>
        @else
            <div></div>
        @endif

        <a href="{{ route('lessons.index', ['category' => $lesson->category]) }}" 
           class="text-gray-400 hover:text-white transition-colors">
            {{ __('common.back_to_lessons') ?? 'Back to Lessons' }}
        </a>

        @if($nextLesson)
            <a href="{{ route('lessons.show', $nextLesson->slug) }}" 
               class="flex items-center text-gray-400 hover:text-white transition-colors">
                <span>{{ __('common.next_lesson') ?? 'Next Lesson' }}</span>
                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </a>
        @else
            <div></div>
        @endif
    </div>
</div>
@endsection
