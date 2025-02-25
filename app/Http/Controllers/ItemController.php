<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = Item::with('categories')->get();
        $categories = Category::all();
        // dd($items->all());
        return view('Admin.items.index',compact('items','categories'));
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
        $path = $request->file('photo')->store('items', 'public');

        $items = Item::create([
            'name' => $request->name,
            'sku' => $request->sku,
            'photo' => $path,
            'stock' => $request->stock,
            'price' => $request->price,
            'category_id' => $request->category_id,
            'description' => $request->description,
        ]);
        
        $items->categories()->sync($request->categories);

        return redirect()->route('items.index')->with('success', 'Item berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Item $item)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Item $item)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Item $item)
    {
        if ($request->hasFile('photo')) {
            // Hapus foto lama jika ada
            if ($item->photo) {
                Storage::disk('public')->delete($item->photo);
            }
    
            // Simpan foto baru
            $photo = $request->file('photo');
            $path = $photo->store('items', 'public');
            $item->photo = $path;
        }
    
        // Update data item
        $item->update([
            'name' => $request->name,
            'sku' => $request->sku,
            'stock' => $request->stock,
            'price' => $request->price,
            'description' => $request->description,
        ]);
    
        // Update kategori (tabel pivot)
        if ($request->categories) {
            $item->categories()->sync($request->categories);
        }
    
        return redirect()->route('items.index')->with('success', 'Barang berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Item $item)
    {
        try{
            if ($item->photo) {
                Storage::disk('public')->delete($item->photo);
            }

            $item->delete();
            return redirect()->route('items.index')->with('success', 'Barang berhasil dihapus!');
        }
        catch (\Exception $e) {
            return redirect()->route('items.index')->with('error', 'Gagal menghapus barang, mungkin barang ini sudah dipakai dalam transaksi lain.');
        }
    }
}
