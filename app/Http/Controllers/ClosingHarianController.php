<?php

namespace App\Http\Controllers;

use App\Models\ClosingHarian;
use App\Models\DetailPenjualan;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ClosingHarianController extends Controller
{
    // GET semua closing
    public function index()
    {
        return response()->json([
            'message' => 'Daftar closing harian',
            'data' => ClosingHarian::all()
        ]);
    }

    // POST - Buat closing harian
    public function store(Request $request)
    {
        $request->validate([
            'cabang_id' => 'required|integer',
            'pengguna_id' => 'required|string|exists:pengguna,id',
            'tanggal' => 'required|date',
        ]);

        // Hitung total penjualan otomatis
        $totalPenjualan = DetailPenjualan::whereHas('penjualan', function ($q) use ($request) {
            $q->where('cabang_id', $request->cabang_id)
              ->whereDate('tanggal', $request->tanggal);
        })->sum('subtotal');

        // Hitung stok akhir otomatis
        $stokAkhir = $this->hitungTotalStok($request->tanggal, $request->cabang_id);

        $closing = ClosingHarian::create([
            'cabang_id' => $request->cabang_id,
            'pengguna_id' => $request->pengguna_id,
            'tanggal' => $request->tanggal,
            'total_penjualan' => $totalPenjualan,
            'stok_akhir' => $stokAkhir,
            'created_at' => Carbon::now(),
        ]);

        return response()->json([
            'message' => 'Closing harian berhasil dibuat',
            'data' => $closing
        ]);
    }

    // PUT - Update closing (tidak ada status lagi)
    public function update(Request $request, $id)
    {
        $closing = ClosingHarian::find($id);

        if (!$closing) {
            return response()->json(['message' => 'Closing tidak ditemukan'], 404);
        }

        return response()->json([
            'message' => 'Tidak ada kolom yang dapat diperbarui (status sudah dihapus)',
            'data' => $closing
        ]);
    }

    // DELETE
    public function destroy($id)
    {
        $closing = ClosingHarian::find($id);

        if (!$closing) {
            return response()->json(['message' => 'Closing tidak ditemukan'], 404);
        }

        $closing->delete();

        return response()->json(['message' => 'Closing berhasil dihapus']);
    }

    // ================================================
    // LOGIC STOK
    // ================================================

    private function hitungStokPerProduk($produkId, $tanggal, $cabangId)
    {
        $stokAwal = DB::table('stok')
            ->where('produk_id', $produkId)
            ->where('cabang_id', $cabangId)
            ->value('jumlah') ?? 0;

        $jumlahTerjual = DetailPenjualan::where('produk_id', $produkId)
            ->whereHas('penjualan', function ($q) use ($tanggal, $cabangId) {
                $q->whereDate('tanggal', $tanggal)
                  ->where('cabang_id', $cabangId);
            })
            ->sum('jumlah');

        return max($stokAwal - $jumlahTerjual, 0);
    }

    private function hitungTotalStok($tanggal, $cabangId)
    {
        $total = 0;

        $produkList = DB::table('stok')
            ->where('cabang_id', $cabangId)
            ->pluck('produk_id');

        foreach ($produkList as $produkId) {
            $total += $this->hitungStokPerProduk($produkId, $tanggal, $cabangId);
        }

        return $total;
    }
}
