<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function index()
    {
        // Get statistics
        $stats = [
            'total_users' => User::where('role', 'user')->count(),
            'total_transactions' => Transaction::count(),
            'total_volume' => Transaction::sum('amount'),
            'recent_transactions' => Transaction::with('user')
                ->latest()
                ->take(5)
                ->get(),
            'suspicious_activity' => $this->getSuspiciousActivity(),
            'daily_transactions' => $this->getDailyTransactionStats(),
        ];

        return view('admin.dashboard', compact('stats'));
    }

    public function users()
    {
        $users = User::where('role', 'user')
            ->withCount('transactions')
            ->withSum('transactions', 'amount')
            ->latest()
            ->paginate(10);

        return view('admin.users', compact('users'));
    }

    public function showUser(User $user)
    {
        if ($user->role === 'admin') {
            abort(403, 'Cannot view admin user details.');
        }

        $user->load(['transactions' => function ($query) {
            $query->latest()->take(10);
        }]);

        return view('admin.user-details', compact('user'));
    }

    public function destroyUser(User $user)
    {
        if ($user->role === 'admin') {
            abort(403, 'Cannot delete admin user.');
        }

        // Delete user's transactions first
        $user->transactions()->delete();
        
        // Delete the user
        $user->delete();

        return redirect()->route('admin.users')
            ->with('success', 'User has been deleted successfully.');
    }

    public function resetUserPassword(User $user, Request $request)
    {
        if ($user->role === 'admin') {
            abort(403, 'Cannot reset admin user password.');
        }

        // Generate password reset token
        $token = Password::createToken($user);
        $resetLink = url('/reset-password/' . $token . '?email=' . urlencode($user->email));

        return redirect()->route('admin.users.show', $user)
            ->with('success', 'Password reset link generated successfully. Please copy and share this link with the user:')
            ->with('resetLink', $resetLink);
    }

    public function transactions()
    {
        $transactions = Transaction::with('user')
            ->latest()
            ->paginate(15);

        return view('admin.transactions', compact('transactions'));
    }

    private function getSuspiciousActivity()
    {
        // Example: Find transactions above 5000 EUR
        return Transaction::where('amount', '>', 5000)
            ->with('user')
            ->latest()
            ->take(5)
            ->get();
    }

    private function getDailyTransactionStats()
    {
        return Transaction::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('COUNT(*) as count'),
            DB::raw('SUM(amount) as total')
        )
        ->groupBy('date')
        ->orderBy('date', 'desc')
        ->take(7)
        ->get();
    }
} 