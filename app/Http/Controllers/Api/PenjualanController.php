<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Penjualan;
use Illuminate\Http\Request;

class PenjualanController extends Controller
{
    // GET semua penjualan
    public function index()
    {
        return $this->daftar();
    }

    // POST tambah penjualan
    public function store(Request $request)
    {
        return $this->simpan($request);
    }

    // GET detail penjualan
    public function show($id)
    {
        return $this->detail($id);
    }

    // DELETE penjualan
    public function destroy($id)
    {
        return $this->hapus($id);
    }
    
    // UPDATE penjualan
    public function update(Request $request, $id)
    {
        return $this->perbarui($request, $id);
    }

    public function daftar()
    {
        $data = Penjualan::with(['cabang', 'pengguna'])->get();

        return response()->json([
            'message' => 'Daftar penjualan',
            'data' => $data
        ]);
    }

    public function simpan(Request $request)
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

    public function detail($id)
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

    public function hapus($id)
    {
        $penjualan = Penjualan::find($id);

        if (!$penjualan) {
            return response()->json(['message' => 'Penjualan tidak ditemukan'], 404);
        }

        $penjualan->delete();

        return response()->json(['message' => 'Penjualan berhasil dihapus']);
    }

    public function perbarui(Request $request, $id)
    {
        $penjualan = Penjualan::find($id);

        if (!$penjualan) {
            return response()->json([
                'message' => 'Penjualan tidak ditemukan'
            ], 404);
        }

        $request->validate([
            'cabang_id' => 'integer|exists:cabang,id',
            'pengguna_id' => 'required|string',
            'tanggal' => 'date',
            'total' => 'numeric',
            'metode_pembayaran' => 'string|max:50',
            'keterangan' => 'nullable|string'
        ]);

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
