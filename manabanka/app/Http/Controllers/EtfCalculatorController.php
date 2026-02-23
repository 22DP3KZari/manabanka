<?php

namespace App\Http\Controllers;

class EtfCalculatorController extends Controller
{
    /**
     * Show the ETF savings plan calculator (client-side calculation, no data stored).
     */
    public function index()
    {
        return view('etf-calculator.index');
    }
}
