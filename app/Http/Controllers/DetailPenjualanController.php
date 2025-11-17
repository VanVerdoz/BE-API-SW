<?php

namespace App\Http\Controllers;

use App\Models\DetailPenjualan;
use Illuminate\Http\Request;

class DetailPenjualanController extends Controller
{
    // GET semua data
    public function index()
    {
        return response()->json([
            'message' => 'Daftar detail penjualan',
            'data' => DetailPenjualan::all()
        ]);
    }

    // POST tambah detail penjualan
    public function store(Request $request)
    {
        $request->validate([
            'penjualan_id' => 'required|integer',
            'produk_id' => 'required|integer',
            'jumlah' => 'required|integer',
            'harga' => 'required|numeric',
        ]);


        $detail = DetailPenjualan::create([
            'penjualan_id' => $request->penjualan_id,
            'produk_id' => $request->produk_id,
            'jumlah' => $request->jumlah,
            'harga' => $request->harga,
        ]);

        return response()->json([
            'message' => 'Detail penjualan berhasil ditambahkan',
            'data' => $detail
        ]);
    }

    // PUT update
    public function update(Request $request, $id)
    {
        $detail = DetailPenjualan::find($id);

        if (!$detail) {
            return response()->json([
                'message' => 'Data detail penjualan tidak ditemukan'
            ], 404);
        }

        $request->validate([
            'jumlah' => 'integer',
            'harga' => 'numeric'
        ]);

        // Recalculate subtotal jika ada perubahan
        $detail->update([
            'jumlah' => $request->jumlah ?? $detail->jumlah,
            'harga' => $request->harga ?? $detail->harga,
        ]);

        return response()->json([
            'message' => 'Detail penjualan berhasil diperbarui',
            'data' => $detail
        ]);
    }

    // DELETE
    public function destroy($id)
    {
        $detail = DetailPenjualan::find($id);

        if (!$detail) {
            return response()->json([
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        $detail->delete();

        return response()->json([
            'message' => 'Detail penjualan berhasil dihapus'
        ]);
    }
}
