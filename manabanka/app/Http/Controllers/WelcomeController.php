<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    // Static landing page entry point for guests.
    public function index()
    {
        return view('welcome');
    }
} 