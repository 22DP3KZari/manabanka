<?php

namespace App\Http\Controllers;

use App\Models\Goal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GoalController extends Controller
{
    // Maintains two goal types used across dashboard and goals pages.
    public function index()
    {
        $goals = Goal::where('user_id', Auth::id())
            ->whereIn('type', [Goal::TYPE_EMERGENCY_FUND, Goal::TYPE_FIRST_ETF_BUY])
            ->get()
            ->keyBy('type');

        return view('goals.index', [
            'emergencyFund' => $goals->get(Goal::TYPE_EMERGENCY_FUND),
            'firstEtfBuy' => $goals->get(Goal::TYPE_FIRST_ETF_BUY),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'emergency_fund_target' => 'nullable|numeric|min:0',
            'emergency_fund_current' => 'nullable|numeric|min:0',
            'first_etf_buy_target' => 'nullable|numeric|min:0',
            'first_etf_buy_current' => 'nullable|numeric|min:0',
        ], [], [
            'emergency_fund_target' => __('common.goal_emergency_target'),
            'emergency_fund_current' => __('common.goal_emergency_current'),
            'first_etf_buy_target' => __('common.goal_etf_target'),
            'first_etf_buy_current' => __('common.goal_etf_current'),
        ]);

        $userId = Auth::id();

        foreach ([Goal::TYPE_EMERGENCY_FUND, Goal::TYPE_FIRST_ETF_BUY] as $type) {
            $prefix = $type === Goal::TYPE_EMERGENCY_FUND ? 'emergency_fund' : 'first_etf_buy';
            $target = (float) ($validated["{$prefix}_target"] ?? 0);
            $current = (float) ($validated["{$prefix}_current"] ?? 0);

            Goal::updateOrCreate(
                [
                    'user_id' => $userId,
                    'type' => $type,
                ],
                [
                    'target_amount' => $target,
                    'current_amount' => $current,
                ]
            );
        }

        return redirect()->route('dashboard')->with('success', __('common.goals_saved'));
    }
}
