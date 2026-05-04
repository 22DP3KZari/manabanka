<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'first_name' => [
                'required',
                'string',
                'min:2',
                'max:30',
                // Allows letters (including accented), hyphens and apostrophes; no spaces, dots or commas
                'regex:/^[\p{L}\-\x27]+$/u',
            ],
            'last_name' => [
                'required',
                'string',
                'min:2',
                'max:30',
                // Allows letters (including accented), hyphens and apostrophes; no spaces, dots or commas
                'regex:/^[\p{L}\-\x27]+$/u',
            ],
            'email' => ['required', 'string', 'email', 'max:30', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'first_name.required' => __('common.first_name_required'),
            'first_name.min' => __('common.first_name_min'),
            'first_name.max' => __('common.first_name_max'),
            'first_name.regex' => __('common.first_name_regex'),
            'last_name.required' => __('common.last_name_required'),
            'last_name.min' => __('common.last_name_min'),
            'last_name.max' => __('common.last_name_max'),
            'last_name.regex' => __('common.last_name_regex'),
            'email.required' => __('common.email_required'),
            'email.email' => __('common.email_email'),
            'email.unique' => __('common.email_unique'),
            'email.max' => __('common.email_max'),
            'password.required' => __('common.password_required'),
            'password.min' => __('common.password_min'),
            'password.confirmed' => __('common.password_confirmed'),
        ]);

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'name' => $request->first_name . ' ' . $request->last_name, // Keep name for backward compatibility
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);

        return redirect()->intended('/dashboard');
    }
} 