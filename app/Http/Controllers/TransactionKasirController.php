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
        // Ambil transaksi hanya milik admin yang sedang login
        $transactions = Transaction::where('user_id', auth()->id())->with('items')->get();
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
        // Validasi input
        $validatedData = $request->validate([
            'description' => 'nullable|string',
            'transaction_date' => 'nullable|date',
            'items' => 'required|array|min:1',
            'quantities' => 'required|array|min:1',
            'status' => 'required|string'
        ]);

        $total = 0;
        $itemsToAttach = [];

        // Validasi stok dan hitung total
        foreach ($request->items as $index => $item_id) {
            $item = Item::find($item_id);
            $quantity = $request->quantities[$index] ?? 1;

            // Cek apakah item ada dan stok mencukupi
            if (!$item) {
                return redirect()->back()->with('error', "Item dengan ID {$item_id} tidak ditemukan.");
            }

            if ($item->stock < $quantity) {
                return redirect()->back()->with('error', "Stok {$item->name} tidak mencukupi! Stok tersedia: {$item->stock}");
            }

            // Tambahkan item ke transaksi
            $itemsToAttach[$item_id] = ['quantity' => $quantity];
            $total += $item->price * $quantity;
        }

        // Buat transaksi baru
        $transaction = Transaction::create([
            'user_id' => auth()->id(), // Ambil ID admin yang sedang login
            'total' => $total,
            'description' => $validatedData['description'],
            'transaction_date' => $validatedData['transaction_date'] ?? now(),
            'status' => $validatedData['status']
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

        return redirect()->route('Kasir.transactions.index')
            ->with('success', 'Transaksi berhasil dibuat!');
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