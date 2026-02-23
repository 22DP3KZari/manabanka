<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Goal extends Model
{
    protected $fillable = [
        'user_id',
        'type',
        'target_amount',
        'current_amount',
    ];

    protected $casts = [
        'target_amount' => 'decimal:2',
        'current_amount' => 'decimal:2',
    ];

    public const TYPE_EMERGENCY_FUND = 'emergency_fund';
    public const TYPE_FIRST_ETF_BUY = 'first_etf_buy';

    public static function typeLabels(): array
    {
        return [
            self::TYPE_EMERGENCY_FUND => __('common.emergency_fund'),
            self::TYPE_FIRST_ETF_BUY => __('common.first_etf_buy'),
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getProgressPercentAttribute(): ?int
    {
        if ((float) $this->target_amount <= 0) {
            return null;
        }
        return (int) min(100, round(((float) $this->current_amount / (float) $this->target_amount) * 100));
    }
}
