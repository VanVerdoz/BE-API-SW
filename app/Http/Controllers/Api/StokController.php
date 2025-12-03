<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Stok;
use Illuminate\Http\Request;

class StokController extends Controller
{
    // GET: list stok
    public function index()
    {
        return $this->daftar();
    }

    // POST: tambah stok
    public function store(Request $request)
    {
        return $this->simpan($request);
    }

    // PUT: update stok
    public function update(Request $request, $id)
    {
        return $this->perbarui($request, $id);
    }

    // DELETE: hapus stok
    public function destroy($id)
    {
        return $this->hapus($id);
    }

    public function daftar()
    {
        return response()->json([
            'message' => 'Data stok',
            'data' => Stok::with(['cabang', 'produk'])->get()
        ]);
    }

    public function simpan(Request $request)
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

    public function perbarui(Request $request, $id)
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

    public function hapus($id)
    {
        $stok = Stok::findOrFail($id);
        $stok->delete();

        return response()->json([
            'message' => 'Stok berhasil dihapus'
        ]);
    }
}
