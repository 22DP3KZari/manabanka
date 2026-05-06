<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Spending;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    // Admin overview: users, spending records, and recent activity snapshots.
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function index()
    {
        // Get statistics
        $stats = [
            'total_users' => User::where('role', 'user')->count(),
            'total_transactions' => Spending::count(),
            'recent_transactions' => Spending::with('user')
                ->latest()
                ->take(5)
                ->get(),
            'daily_transactions' => $this->getDailyTransactionStats(),
        ];

        return view('admin.dashboard', compact('stats'));
    }

    public function users()
    {
        $users = User::where('role', 'user')
            ->withCount('spendings')
            ->withSum('spendings', 'amount')
            ->latest()
            ->paginate(10);

        return view('admin.users', compact('users'));
    }

    public function showUser(User $user)
    {
        if ($user->role === 'admin') {
            abort(403, 'Cannot view admin user details.');
        }

        $user->load(['spendings' => function ($query) {
            $query->latest()->take(10);
        }]);

        return view('admin.user-details', compact('user'));
    }

    public function destroyUser(User $user)
    {
        if ($user->role === 'admin') {
            abort(403, 'Cannot delete admin user.');
        }

        // Delete user's spendings first
        $user->spendings()->delete();
        
        // Delete the user
        $user->delete();

        return redirect()->route('admin.users')
            ->with('success', 'User has been deleted successfully.');
    }

    public function transactions()
    {
        $transactions = Spending::with('user')
            ->latest()
            ->paginate(15);

        return view('admin.transactions', compact('transactions'));
    }

    private function getSuspiciousActivity()
    {
        // Example: Find spendings above 5000 EUR
        return Spending::where('amount', '>', 5000)
            ->with('user')
            ->latest()
            ->take(5)
            ->get();
    }

    private function getDailyTransactionStats()
    {
        return Spending::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('COUNT(*) as count'),
            DB::raw('SUM(amount) as total')
        )
        ->groupBy(DB::raw('DATE(created_at)'))
        ->orderByRaw('DATE(created_at) DESC')
        ->take(7)
        ->get();
    }
} 