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
            'pengguna_id' => 'required|integer',
            'tanggal' => 'required|date',
            'status' => 'required|string',
        ]);

        // Hitung total penjualan otomatis
        $totalPenjualan = DetailPenjualan::whereHas('penjualan', function ($q) use ($request) {
            $q->where('cabang_id', $request->cabang_id)
              ->whereDate('tanggal', $request->tanggal);
        })->sum('subtotal');

        // Hitung stok akhir otomatis dari tabel stok
        $stokAkhir = $this->hitungTotalStok($request->tanggal, $request->cabang_id);

        $closing = ClosingHarian::create([
            'cabang_id' => $request->cabang_id,
            'pengguna_id' => $request->pengguna_id,
            'tanggal' => $request->tanggal,
            'total_penjualan' => $totalPenjualan,
            'stok_akhir' => $stokAkhir,
            'status' => $request->status,
            'created_at' => Carbon::now(),
        ]);

        return response()->json([
            'message' => 'Closing harian berhasil dibuat',
            'data' => $closing
        ]);
    }

    // PUT - Update closing
    public function update(Request $request, $id)
    {
        $closing = ClosingHarian::find($id);

        if (!$closing) {
            return response()->json(['message' => 'Closing tidak ditemukan'], 404);
        }

        $request->validate([
            'status' => 'string',
        ]);

        $closing->update([
            'status' => $request->status ?? $closing->status,
        ]);

        return response()->json([
            'message' => 'Closing harian diperbarui',
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

    // Hitung stok per produk
    private function hitungStokPerProduk($produkId, $tanggal, $cabangId)
    {
        // Stok awal berdasarkan tabel stok
        $stokAwal = DB::table('stok')
            ->where('produk_id', $produkId)
            ->where('cabang_id', $cabangId)
            ->value('jumlah') ?? 0;

        // Hitung jumlah terjual
        $jumlahTerjual = DetailPenjualan::where('produk_id', $produkId)
            ->whereHas('penjualan', function ($q) use ($tanggal, $cabangId) {
                $q->whereDate('tanggal', $tanggal)
                  ->where('cabang_id', $cabangId);
            })
            ->sum('jumlah');

        return max($stokAwal - $jumlahTerjual, 0);
    }

    // Hitung total stok semua produk per cabang
    private function hitungTotalStok($tanggal, $cabangId)
    {
        $total = 0;

        // Ambil semua produk yg ada stok-nya
        $produkList = DB::table('stok')
            ->where('cabang_id', $cabangId)
            ->pluck('produk_id');

        foreach ($produkList as $produkId) {
            $total += $this->hitungStokPerProduk($produkId, $tanggal, $cabangId);
        }

        return $total;
    }
}
