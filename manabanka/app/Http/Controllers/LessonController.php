<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use App\Models\LessonProgress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LessonController extends Controller
{
    public function index(Request $request)
    {
        $category = $request->get('category');
        
        $query = Lesson::where('is_published', true);
        
        if ($category) {
            $query->where('category', $category);
        }
        
        $lessons = $query->orderBy('category')
            ->orderBy('order')
            ->get()
            ->map(function ($lesson) {
                // Add localized attributes
                $lesson->localized_title = $lesson->localized_title;
                $lesson->localized_description = $lesson->localized_description;
                return $lesson;
            })
            ->groupBy('category');
        
        // Get user progress for all lessons
        $userProgress = [];
        if (Auth::check()) {
            $progressRecords = LessonProgress::where('user_id', Auth::id())
                ->get()
                ->keyBy('lesson_id');
            
            foreach ($lessons->flatten() as $lesson) {
                $progress = $progressRecords->get($lesson->id);
                $userProgress[$lesson->id] = [
                    'completed' => $progress ? $progress->completed : false,
                    'progress_percentage' => $progress ? $progress->progress_percentage : 0,
                ];
            }
        }
        
        $categories = [
            'basics' => __('common.category_basics') ?? 'Basics',
            'etf' => __('common.category_etf') ?? 'ETFs',
            'sp500' => __('common.category_sp500') ?? 'S&P 500',
            'risk' => __('common.category_risk') ?? 'Risk Management',
            'savings' => __('common.category_savings') ?? 'Savings',
        ];
        
        return view('lessons.index', compact('lessons', 'userProgress', 'categories', 'category'));
    }

    public function show($slug)
    {
        $lesson = Lesson::where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();
        
        $userProgress = null;
        if (Auth::check()) {
            $userProgress = LessonProgress::where('user_id', Auth::id())
                ->where('lesson_id', $lesson->id)
                ->first();
            
            // If no progress exists, create one
            if (!$userProgress) {
                $userProgress = LessonProgress::create([
                    'user_id' => Auth::id(),
                    'lesson_id' => $lesson->id,
                    'started_at' => now(),
                ]);
            }
        }
        
        // Get categories for breadcrumb
        $categories = [
            'basics' => __('common.category_basics') ?? 'Basics',
            'etf' => __('common.category_etf') ?? 'ETFs',
            'sp500' => __('common.category_sp500') ?? 'S&P 500',
            'risk' => __('common.category_risk') ?? 'Risk Management',
            'savings' => __('common.category_savings') ?? 'Savings',
        ];
        
        // Get next and previous lessons
        $nextLesson = Lesson::where('is_published', true)
            ->where('category', $lesson->category)
            ->where('order', '>', $lesson->order)
            ->orderBy('order')
            ->first();
        
        $prevLesson = Lesson::where('is_published', true)
            ->where('category', $lesson->category)
            ->where('order', '<', $lesson->order)
            ->orderBy('order', 'desc')
            ->first();
        
        return view('lessons.show', compact('lesson', 'userProgress', 'nextLesson', 'prevLesson', 'categories'));
    }

    public function markComplete(Request $request, $slug)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        
        $lesson = Lesson::where('slug', $slug)->firstOrFail();
        
        $progress = LessonProgress::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'lesson_id' => $lesson->id,
            ],
            [
                'completed' => true,
                'completed_at' => now(),
                'progress_percentage' => 100,
            ]
        );
        
        if (!$progress->started_at) {
            $progress->update(['started_at' => now()]);
        }
        
        return redirect()->route('lessons.show', $slug)
            ->with('success', __('common.lesson_completed') ?? 'Lesson marked as completed!');
    }

    public function updateProgress(Request $request, $slug)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        
        $lesson = Lesson::where('slug', $slug)->firstOrFail();
        
        $validated = $request->validate([
            'progress_percentage' => 'required|integer|min:0|max:100',
        ]);
        
        $progress = LessonProgress::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'lesson_id' => $lesson->id,
            ],
            [
                'progress_percentage' => $validated['progress_percentage'],
                'started_at' => now(),
            ]
        );
        
        // Auto-complete if progress is 100%
        if ($validated['progress_percentage'] >= 100 && !$progress->completed) {
            $progress->update([
                'completed' => true,
                'completed_at' => now(),
            ]);
        }
        
        return response()->json(['success' => true, 'progress' => $progress->progress_percentage]);
    }
}
