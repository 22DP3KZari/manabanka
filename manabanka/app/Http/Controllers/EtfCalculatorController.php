<?php

namespace App\Http\Controllers;

class EtfCalculatorController extends Controller
{
    // Serves a client-side educational calculator; no user data is persisted here.
    /**
     * Show the ETF savings plan calculator (client-side calculation, no data stored).
     */
    public function index()
    {
        return view('etf-calculator.index');
    }
}
