<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryBudget extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'budget_id',
        'category',
        'monthly_budget',
        'year',
        'month',
    ];

    protected $casts = [
        'monthly_budget' => 'decimal:2',
        'year' => 'integer',
        'month' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function budget()
    {
        return $this->belongsTo(Budget::class);
    }

    /**
     * Get actual spending for this category in the budget period
     */
    public function getActualSpendingAttribute()
    {
        return Spending::where('user_id', $this->user_id)
            ->where('category', $this->category)
            ->whereYear('date', $this->year)
            ->whereMonth('date', $this->month)
            ->sum('amount');
    }

    /**
     * Get budget health status
     */
    public function getHealthStatusAttribute()
    {
        $actual = $this->actual_spending;
        $budget = $this->monthly_budget;
        
        if ($budget == 0) return 'no_budget';
        
        $percentage = ($actual / $budget) * 100;
        
        if ($percentage <= 80) return 'on_track';
        if ($percentage <= 100) return 'warning';
        return 'over_budget';
    }
}
