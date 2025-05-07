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
            'recipient_account' => 'required|string|size:20',
            'recipient_name' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0.01|max:10000',
            'description' => 'nullable|string|max:255',
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