<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransferController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function showTransferForm()
    {
        return view('transfers.create');
    }

    public function transfer(Request $request)
    {
        $validated = $request->validate([
            'recipient_account' => ['required', 'string', 'min:21', 'max:34', 'regex:/^[A-Za-z0-9]+$/'],
            'recipient_name' => ['required', 'string', 'min:2', 'max:255', 'regex:/^[A-Za-z\s]+$/'],
            'amount' => 'required|numeric|min:0.01|max:10000',
            'description' => 'nullable|string|max:255',
        ], [
            'recipient_account.min' => 'The recipient account must be at least 21 characters.',
            'recipient_account.max' => 'The recipient account may not be greater than 34 characters.',
            'recipient_account.regex' => 'The recipient account may only contain letters and numbers.',
            'recipient_name.min' => 'The recipient name should be at least 2 characters.',
            'recipient_name.regex' => 'The recipient name may only contain letters and spaces.',
        ]);

        // Create the transaction
        $transaction = Transaction::create([
            'user_id' => Auth::id(),
            'type' => 'transfer',
            'amount' => $validated['amount'],
            'recipient_account' => $validated['recipient_account'],
            'recipient_name' => $validated['recipient_name'],
            'description' => $validated['description'],
            'status' => 'completed' // In a real app, this would be 'pending' until confirmed
        ]);

        return redirect()->route('transfers.show', $transaction)
            ->with('success', 'Transfer completed successfully!');
    }

    public function show(Transaction $transaction)
    {
        // Ensure the user can only view their own transactions
        if ($transaction->user_id !== Auth::id()) {
            abort(403);
        }

        return view('transfers.show', compact('transaction'));
    }
} 