<?php 
namespace App\Http\Controllers;

use App\Models\LaporanKeuangan;
use Illuminate\Http\Request;

class LaporanKeuanganController extends Controller
{
    // GET ALL
    public function index()
    {
        return response()->json([
            'message' => 'Daftar laporan keuangan',
            'data' => LaporanKeuangan::orderBy('id', 'DESC')->get()
        ]);
    }

    // GET BY ID
    public function show($id)
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

    // POST CREATE
    public function store(Request $request)
    {
        $request->validate([
            'cabang_id' => 'required|integer',
            'periode_awal' => 'required|date',
            'periode_akhir' => 'required|date',
            'total_pendapatan' => 'required|integer',
            'total_pengeluaran' => 'required|integer',
            'dibuat_oleh' => 'required|string'
        ]);

        $laporan = LaporanKeuangan::create([
            'cabang_id' => $request->cabang_id,
            'periode_awal' => $request->periode_awal,
            'periode_akhir' => $request->periode_akhir,
            'total_pendapatan' => $request->total_pendapatan,
            'total_pengeluaran' => $request->total_pengeluaran,
            'dibuat_oleh' => $request->dibuat_oleh
        ]);

        return response()->json([
            'message' => 'Laporan berhasil dibuat',
            'data' => $laporan
        ]);
    }

    // PUT UPDATE
    public function update(Request $request, $id)
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
            'total_pengeluaran' => 'required|integer',
            'dibuat_oleh' => 'required|string'
        ]);


        $laporan->update([
            'cabang_id' => $request->cabang_id,
            'periode_awal' => $request->periode_awal,
            'periode_akhir' => $request->periode_akhir,
            'total_pendapatan' => $request->total_pendapatan,
            'total_pengeluaran' => $request->total_pengeluaran,
            'dibuat_oleh' => $request->dibuat_oleh
        ]);

        return response()->json([
            'message' => 'Laporan berhasil diupdate',
            'data' => $laporan
        ]);
    }

    // DELETE
    public function destroy($id)
    {
        $laporan = LaporanKeuangan::find($id);

        if (!$laporan) {
            return response()->json(['message' => 'Laporan tidak ditemukan'], 404);
        }

        $laporan->delete();

        return response()->json(['message' => 'Laporan berhasil dihapus']);
    }
}
