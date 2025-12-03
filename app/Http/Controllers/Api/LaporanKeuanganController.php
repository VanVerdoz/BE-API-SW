<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\LaporanKeuangan;
use Illuminate\Http\Request;

class LaporanKeuanganController extends Controller
{
    // GET ALL
    public function index()
    {
        return $this->daftar();
    }

    // GET BY ID
    public function show($id)
    {
        return $this->detail($id);
    }

    // POST CREATE
    public function store(Request $request)
    {
        return $this->simpan($request);
    }

    // PUT UPDATE
    public function update(Request $request, $id)
    {
        return $this->perbarui($request, $id);
    }

    // DELETE
    public function destroy($id)
    {
        return $this->hapus($id);
    }

    public function daftar()
    {
        return response()->json([
            'message' => 'Daftar laporan keuangan',
            'data' => LaporanKeuangan::with('cabang')->orderBy('id', 'DESC')->get()
        ]);
    }

    public function detail($id)
    {
        $laporan = LaporanKeuangan::find($id);

        if (!$laporan) {
            return response()->json(['message' => 'Laporan tidak ditemukan'], 404);
        }

        return response()->json([
            'message' => 'Detail laporan',
            'data' => $laporan
        ]);
    }

    public function simpan(Request $request)
    {
        $request->validate([
            'cabang_id' => 'required|integer',
            'periode_awal' => 'required|date',
            'periode_akhir' => 'required|date',
            'total_pendapatan' => 'required|integer',
        ]);

        $laporan = LaporanKeuangan::create([
            'cabang_id' => $request->cabang_id,
            'periode_awal' => $request->periode_awal,
            'periode_akhir' => $request->periode_akhir,
            'total_pendapatan' => $request->total_pendapatan,
            'dibuat_oleh' => $request->dibuat_oleh
        ]);

        return response()->json([
            'message' => 'Laporan berhasil dibuat',
            'data' => $laporan
        ]);
    }

    public function perbarui(Request $request, $id)
    {
        $laporan = LaporanKeuangan::find($id);

        if (!$laporan) {
            return response()->json(['message' => 'Laporan tidak ditemukan'], 404);
        }

        $request->validate([
            'cabang_id' => 'required|integer',
            'periode_awal' => 'required|date',
            'periode_akhir' => 'required|date',
            'total_pendapatan' => 'required|integer',
            'dibuat_oleh' => 'required|string'
        ]);

        $laporan->update([
            'cabang_id' => $request->cabang_id,
            'periode_awal' => $request->periode_awal,
            'periode_akhir' => $request->periode_akhir,
            'total_pendapatan' => $request->total_pendapatan,
            'dibuat_oleh' => $request->dibuat_oleh
        ]);

        return response()->json([
            'message' => 'Laporan berhasil diupdate',
            'data' => $laporan
        ]);
    }

    public function hapus($id)
    {
        $laporan = LaporanKeuangan::find($id);

        if (!$laporan) {
            return response()->json(['message' => 'Laporan tidak ditemukan'], 404);
        }

        $laporan->delete();

        return response()->json(['message' => 'Laporan berhasil dihapus']);
    }
}
