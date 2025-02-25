<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transactions = Transaction::all();
        $items = Item::all();
        $admins = User::role('admin')->get();
        return view('Admin.transactions.index', compact('transactions', 'items', 'admins'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $transaction = Transaction::with(['admin', 'items'])->findOrFail($id);

        // Ambil semua transaksi yang dilakukan oleh admin ini
        $transactionsByUser = Transaction::where('user_id', $transaction->user_id)
            ->orderBy('transaction_date', 'desc')
            ->get();

        return view('Admin.transactions.show', compact('transaction', 'transactionsByUser'));
    }




    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transaction $transaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction)
    {
        //
    }
}
