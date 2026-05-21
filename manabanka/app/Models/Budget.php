<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Budget extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'age',
        'income',
        'fixed_expenses',
        'wants',
        'savings',
        'other',
        'dependents',
        'debt',
        'goal',
        'detailed_expenses',
    ];

    protected $casts = [
        'detailed_expenses' => 'array',
        'income' => 'decimal:2',
        'fixed_expenses' => 'decimal:2',
        'wants' => 'decimal:2',
        'savings' => 'decimal:2',
        'other' => 'decimal:2',
    ];

    public function categoryBudgets()
    {
        return $this->hasMany(CategoryBudget::class);
    }

    /** Default auto name (always Latvian), e.g. "maija budžets 2026 (21.05.2026)". */
    public static function defaultAutoName(?Carbon $at = null): string
    {
        $at = ($at ?? now())->copy();
        $genitiveMonths = [
            1 => 'janvāra', 2 => 'februāra', 3 => 'marta', 4 => 'aprīļa', 5 => 'maija',
            6 => 'jūnija', 7 => 'jūlija', 8 => 'augusta', 9 => 'septembra', 10 => 'oktobra',
            11 => 'novembra', 12 => 'decembra',
        ];

        return sprintf(
            '%s budžets %s (%s)',
            $genitiveMonths[(int) $at->month],
            $at->format('Y'),
            $at->format('d.m.Y')
        );
    }

    public function getDisplayLabelAttribute(): string
    {
        return $this->name ?: self::defaultAutoName($this->created_at);
    }
} 