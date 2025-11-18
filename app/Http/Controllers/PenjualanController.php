<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use Illuminate\Http\Request;

class PenjualanController extends Controller
{
    // GET semua penjualan
    public function index()
    {
        $data = Penjualan::with(['cabang', 'pengguna'])->get();

        return response()->json([
            'message' => 'Daftar penjualan',
            'data' => $data
        ]);
    }

    // POST tambah penjualan
    public function store(Request $request)
    {
        $request->validate([
            'cabang_id' => 'required|integer',
            'pengguna_id' => 'required|string',
            'tanggal' => 'required|date',
            'total' => 'required|numeric',
            'metode_pembayaran' => 'required|string',
            'keterangan' => 'nullable|string',
        ]);

        $penjualan = Penjualan::create([
            'cabang_id' => $request->cabang_id,
            'pengguna_id' => $request->pengguna_id,
            'tanggal' => $request->tanggal,
            'total' => $request->total,
            'metode_pembayaran' => $request->metode_pembayaran,
            'keterangan' => $request->keterangan
        ]);

        return response()->json([
            'message' => 'Penjualan berhasil ditambahkan',
            'data' => $penjualan
        ], 201);
    }

    // GET detail penjualan
    public function show($id)
    {
        $penjualan = Penjualan::with(['cabang', 'pengguna'])->find($id);

        if (!$penjualan) {
            return response()->json(['message' => 'Penjualan tidak ditemukan'], 404);
        }

        return response()->json([
            'message' => 'Detail penjualan',
            'data' => $penjualan
        ]);
    }

    // DELETE penjualan
    public function destroy($id)
    {
        $penjualan = Penjualan::find($id);

        if (!$penjualan) {
            return response()->json(['message' => 'Penjualan tidak ditemukan'], 404);
        }

        $penjualan->delete();

        return response()->json(['message' => 'Penjualan berhasil dihapus']);
    }
    
    // UPDATE penjualan
    public function update(Request $request, $id)
{
    // Cari data penjualan
    $penjualan = Penjualan::find($id);

    if (!$penjualan) {
        return response()->json([
            'message' => 'Penjualan tidak ditemukan'
        ], 404);
    }

    // Validasi input
    $request->validate([
        'cabang_id' => 'integer|exists:cabang,id',
        'pengguna_id' => 'required|string',
        'tanggal' => 'date',
        'total' => 'numeric',
        'metode_pembayaran' => 'string|max:50',
        'keterangan' => 'nullable|string'
    ]);

    // Update data
    $penjualan->update([
        'cabang_id' => $request->cabang_id ?? $penjualan->cabang_id,
        'pengguna_id' => $request->pengguna_id ?? $penjualan->pengguna_id,
        'tanggal' => $request->tanggal ?? $penjualan->tanggal,
        'total' => $request->total ?? $penjualan->total,
        'metode_pembayaran' => $request->metode_pembayaran ?? $penjualan->metode_pembayaran,
        'keterangan' => $request->keterangan ?? $penjualan->keterangan,
    ]);

    return response()->json([
        'message' => 'Penjualan berhasil diperbarui',
        'data' => $penjualan
    ]);
}

}
