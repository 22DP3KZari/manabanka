<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\TransferController;
use App\Http\Controllers\Admin\DashboardController;
use App\Models\User;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\PasswordReset;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\StatementController;
use App\Http\Controllers\BudgetPlannerController;

// Redirect root to login if not authenticated
Route::get('/', function () {
    if (auth()->check()) {
        return redirect('/dashboard');
    }
    return redirect('/login');
});

Route::get('/contact', function () {
    return view('contact');
});

// Authentication Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Registration Routes
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Password Reset Routes
Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])
    ->middleware('guest')
    ->name('password.request');

Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])
    ->middleware('guest')
    ->name('password.email');

Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])
    ->middleware('guest')
    ->name('password.reset');

Route::post('/reset-password', [ResetPasswordController::class, 'reset'])
    ->middleware('guest')
    ->name('password.update');

// Protected Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Transfer routes
    Route::get('/transfers/create', [TransferController::class, 'showTransferForm'])->name('transfers.create');
    Route::post('/transfers', [TransferController::class, 'transfer'])->name('transfers.store');
    Route::get('/transfers/{transaction}', [TransferController::class, 'show'])->name('transfers.show');

    // Statement routes
    Route::get('/statements', [StatementController::class, 'index'])->name('statements.index');

    // Budget Planner routes
    Route::get('/budget-planner', [BudgetPlannerController::class, 'index'])->name('budget-planner.index');
    Route::post('/budget-planner/calculate', [\App\Http\Controllers\BudgetPlannerController::class, 'calculate'])->name('budget-planner.calculate');
    Route::get('/budgets', [BudgetPlannerController::class, 'budgets'])->name('budgets.index');
    Route::delete('/budgets/{budget}', [BudgetPlannerController::class, 'destroy'])->name('budgets.destroy');
    Route::get('/budgets/{budget}', [BudgetPlannerController::class, 'show'])->name('budgets.show');
    Route::get('/budgets/{budget}/edit', [BudgetPlannerController::class, 'edit'])->name('budgets.edit');
    Route::patch('/budgets/{budget}', [BudgetPlannerController::class, 'update'])->name('budgets.update');
});

// Admin Routes
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }
        return app(DashboardController::class)->index();
    })->name('dashboard');
    
    Route::get('/users', function () {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }
        return app(DashboardController::class)->users();
    })->name('users');

    Route::get('/users/{user}', function (User $user) {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }
        return app(DashboardController::class)->showUser($user);
    })->name('users.show');

    Route::post('/users/{user}/reset-password', function (User $user, Request $request) {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }
        return app(DashboardController::class)->resetUserPassword($user, $request);
    })->name('users.reset-password');

    Route::delete('/users/{user}', function (User $user) {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }
        return app(DashboardController::class)->destroyUser($user);
    })->name('users.destroy');
    
    Route::get('/transactions', function () {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }
        return app(DashboardController::class)->transactions();
    })->name('transactions');
});
