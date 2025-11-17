<?php

namespace App\Http\Controllers;

use App\Models\Stok;
use Illuminate\Http\Request;

class StokController extends Controller
{
    // GET: list stok
    public function index()
    {
        return response()->json([
            'message' => 'Data stok',
            'data' => Stok::with(['cabang', 'produk'])->get()
        ]);
    }

    // POST: tambah stok
    public function store(Request $request)
    {
        $request->validate([
            'cabang_id' => 'required|integer',
            'produk_id' => 'required|integer',
            'jumlah' => 'required|integer'
        ]);

        $stok = Stok::create([
            'cabang_id' => $request->cabang_id,
            'produk_id' => $request->produk_id,
            'jumlah' => $request->jumlah
        ]);

        return response()->json([
            'message' => 'Stok berhasil ditambah',
            'data' => $stok
        ]);
    }

    // PUT: update stok
    public function update(Request $request, $id)
    {
        $request->validate([
            'jumlah' => 'required|integer'
        ]);

        $stok = Stok::findOrFail($id);
        $stok->jumlah = $request->jumlah;
        $stok->updated_at = now();
        $stok->save();

        return response()->json([
            'message' => 'Stok berhasil diperbarui',
            'data' => $stok
        ]);
    }

    // DELETE: hapus stok
    public function destroy($id)
    {
        $stok = Stok::findOrFail($id);
        $stok->delete();

        return response()->json([
            'message' => 'Stok berhasil dihapus'
        ]);
    }
}
