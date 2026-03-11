<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = \App\Models\Transaction::with('user')->get();
        return view('admin.transactions.index', compact('transactions'));
    }


    public function create()
{
    $users = \App\Models\User::orderBy('name')->get();
    return view('admin.transactions.create', compact('users'));
}

public function store(Request $request)
{
    $validated = $request->validate([
        'user_id' => 'required|integer|exists:users,id',
        'service' => 'nullable|string|max:255',
        'source' => 'required|string|max:255',
        'amount' => 'required|numeric|min:0',
        'status' => 'required|string|max:255',
        'note' => 'nullable|string',
        'transaction_date' => 'nullable|date',
    ]);
    Transaction::create($validated);
    return redirect()->route('admin.transactions.index')->with('success', 'Transaction created.');
}

    public function edit($transaction)
{
    $transaction = \App\Models\Transaction::find($transaction);
    $users = \App\Models\User::orderBy('name')->get();
    if (!$transaction) {
        return back()->with('error', 'Transaction not found.');
    }
    return view('admin.transactions.edit', compact('transaction', 'users'));
}

public function update(Request $request, $transaction)
{
    $validated = $request->validate([
        'user_id' => 'required|integer|exists:users,id',
        'service' => 'nullable|string|max:255',
        'source' => 'required|string|max:255',
        'amount' => 'required|numeric|min:0',
        'status' => 'required|string|max:255',
        'note' => 'nullable|string',
        'transaction_date' => 'nullable|date',
    ]);
    $transaction = \App\Models\Transaction::find($transaction);
    if (!$transaction) {
        return back()->with('error', 'Transaction not found.');
    }
    $transaction->update($validated);
    return redirect()->route('admin.transactions.index')->with('success', 'Transaction updated.');
}

    public function destroy($transaction)
    {
        $transaction = \App\Models\Transaction::find($transaction);
        if (!$transaction) {
            return back()->with('error', 'Transaction not found.');
        }
        $transaction->delete();
        return back()->with('success', 'Transaction deleted.');
    }
}
