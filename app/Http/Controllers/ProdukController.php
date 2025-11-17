<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
public function index()
    {
        $produk = Produk::all()->map(function ($item) {
            $item->harga_format = 'Rp. ' . number_format($item->harga, 0, ',', '.');
            return $item;
        });

        return response()->json([
            'message' => 'Daftar produk',
            'data' => $produk
        ]);
    }
public function store(Request $request)
{
    $request->validate([
        'nama_produk' => 'required',
        'harga' => 'required|integer',
        'kategori' => 'required',
        'status' => 'required',
        'deskripsi' => 'nullable|string'
    ]);

    $produk = Produk::create($request->all());
    $produk->harga_format = 'Rp. ' . number_format($produk->harga, 0, ',', '.');

    return response()->json([
        'message' => 'Produk berhasil dibuat',
        'data' => $produk
    ], 201);
}
public function update(Request $request, $id)
{
    $produk = Produk::findOrFail($id);

    $produk->update($request->all());
    $produk->harga_format = 'Rp. ' . number_format($produk->harga, 0, ',', '.');

    return response()->json([
        'message' => 'Produk berhasil diperbarui',
        'data' => $produk
    ]);
}
public function destroy($id)
{
    Produk::destroy($id);

    return response()->json(['message' => 'Produk dihapus']);
}
}
