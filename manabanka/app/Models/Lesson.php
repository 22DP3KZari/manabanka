<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Lesson extends Model
{
    protected $fillable = [
        'title',
        'title_lv',
        'slug',
        'description',
        'description_lv',
        'content',
        'content_lv',
        'category',
        'order',
        'duration_minutes',
        'difficulty',
        'is_published',
    ];

    // Accessors to get the correct language version
    public function getLocalizedTitleAttribute()
    {
        $locale = app()->getLocale();
        if ($locale === 'lv' && $this->title_lv) {
            return $this->title_lv;
        }
        return $this->title;
    }

    public function getLocalizedDescriptionAttribute()
    {
        $locale = app()->getLocale();
        if ($locale === 'lv' && $this->description_lv) {
            return $this->description_lv;
        }
        return $this->description;
    }

    public function getLocalizedContentAttribute()
    {
        $locale = app()->getLocale();
        if ($locale === 'lv' && $this->content_lv) {
            return $this->content_lv;
        }
        return $this->content;
    }

    protected $casts = [
        'is_published' => 'boolean',
        'order' => 'integer',
        'duration_minutes' => 'integer',
    ];

    public function progress()
    {
        return $this->hasMany(LessonProgress::class);
    }

    public function userProgress($userId)
    {
        return $this->progress()->where('user_id', $userId)->first();
    }

    // Auto-generate slug from title
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($lesson) {
            if (empty($lesson->slug)) {
                $lesson->slug = Str::slug($lesson->title);
            }
        });
    }
}
