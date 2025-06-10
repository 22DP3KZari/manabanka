<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Budget extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
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
} 