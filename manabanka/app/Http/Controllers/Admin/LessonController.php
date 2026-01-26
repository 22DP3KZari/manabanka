<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lesson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LessonController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function index()
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        $lessons = Lesson::orderBy('category')
            ->orderBy('order')
            ->get()
            ->groupBy('category');

        $categories = [
            'basics' => 'Basics',
            'etf' => 'ETFs',
            'sp500' => 'S&P 500',
            'risk' => 'Risk Management',
            'savings' => 'Savings',
        ];

        return view('admin.lessons.index', compact('lessons', 'categories'));
    }

    public function edit(Lesson $lesson)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        return view('admin.lessons.edit', compact('lesson'));
    }

    public function update(Request $request, Lesson $lesson)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'title_lv' => 'nullable|string|max:255',
            'description_lv' => 'nullable|string|max:1000',
            'content_lv' => 'nullable|string',
        ]);

        $lesson->update($validated);

        return redirect()->route('admin.lessons.index')
            ->with('success', 'Lesson translations updated successfully.');
    }
}
