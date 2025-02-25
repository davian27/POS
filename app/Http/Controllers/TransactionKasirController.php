<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Transaction;
use App\Models\User;

class TransactionKasirController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transactions = Transaction::all();
        $items = Item::all();
        $admins = User::role('admin')->get();
        return view('Kasir.transactions.index', compact('transactions', 'items', 'admins'));
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
        $total = 0;
        $itemsToAttach = [];

        foreach ($request->items as $index => $item_id) {
            $item = Item::find($item_id);
            $quantity = $request->quantities[$index] ?? 1;

            // Cek apakah stok cukup sebelum menyimpan gambar
            if (!$item || $item->stock < $quantity) {
                return redirect()->back()->with('error', "Stok untuk {$item->name} tidak mencukupi! Stok tersedia: {$item->stock}");
            }

            // Tambahkan item ke transaksi (jika stok cukup)
            $itemsToAttach[$item_id] = ['quantity' => $quantity];
            $total += $item->price * $quantity;
        }

        // Buat transaksi baru setelah stok diverifikasi
        $transaction = Transaction::create([
            'user_id' => $request->user_id,
            'total' => $total,
            'description' => $request->description,
            'transaction_date' => $request->transaction_date ?? now(),
            'status' => $request->status,
        ]);

        // Simpan item yang telah diverifikasi ke transaksi
        $transaction->items()->attach($itemsToAttach);

        // Kurangi stok setelah transaksi berhasil dibuat
        foreach ($request->items as $index => $item_id) {
            $item = Item::find($item_id);
            $quantity = $request->quantities[$index] ?? 1;
            $item->stock -= $quantity;
            $item->save();
        }

        return redirect()->route('Kasir.transactions.index')->with('success', 'Transaction created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
