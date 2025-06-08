<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Mail;
use App\Mail\PasswordResetMail;
use App\Models\User;

class ForgotPasswordController extends Controller
{
    public function showLinkRequestForm()
    {
        return view('auth.forgot-password');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $token = Password::createToken(User::where('email', $request->email)->first());
        $resetLink = url('/reset-password/' . $token . '?email=' . urlencode($request->email));

        return back()->with('status', 'Please copy and paste this link into a new browser tab to reset your password: ' . $resetLink);
    }
} 