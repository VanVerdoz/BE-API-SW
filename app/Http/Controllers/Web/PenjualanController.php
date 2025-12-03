<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Penjualan;
use App\Models\DetailPenjualan;
use App\Models\Produk;
use App\Models\Cabang;

class PenjualanController extends Controller
{
    public function index()
    {
            $userId = session('user.id');
            $role = session('user.role');

            $query = Penjualan::with(['cabang', 'pengguna', 'detail_penjualan.produk'])
                ->orderBy('tanggal', 'desc')
                ->where(function ($q) {
                    $q->whereNull('metode_pembayaran')
                      ->orWhere('metode_pembayaran', '!=', 'request_stok');
                });

            // Raider hanya melihat transaksi miliknya sendiri
            if ($role === 'raider' && $userId) {
                $query->where('pengguna_id', $userId);
            }

            $penjualan = $query->get();

            // Rekap penjualan harian khusus untuk raider
            $totalPendapatanHariIni = null;
            $totalProdukHariIni = null;

            if ($role === 'raider' && $userId) {
                $totalPendapatanHariIni = Penjualan::where('pengguna_id', $userId)
                    ->whereDate('tanggal', today())
                    ->where(function ($q) {
                        $q->whereNull('metode_pembayaran')
                          ->orWhere('metode_pembayaran', '!=', 'request_stok');
                    })
                    ->sum('total');

                $totalProdukHariIni = DetailPenjualan::whereHas('penjualan', function ($q) use ($userId) {
                    $q->where('pengguna_id', $userId)
                        ->whereDate('tanggal', today())
                        ->where(function ($q2) {
                            $q2->whereNull('metode_pembayaran')
                               ->orWhere('metode_pembayaran', '!=', 'request_stok');
                        });
                })->sum('jumlah');
            }

            return view('penjualan.index', compact('penjualan', 'totalPendapatanHariIni', 'totalProdukHariIni'));
    }

    public function create()
    {
        $produk = Produk::where('status', 'aktif')->get();
        $cabang = Cabang::all();
        return view('penjualan.create', compact('produk', 'cabang'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'cabang_id' => 'required|exists:cabang,id',
            'tanggal' => 'required|date',
            'total' => 'required|numeric',
            'metode_pembayaran' => 'required|string',
            'keterangan' => 'nullable|string',
            'produk_id' => 'nullable|exists:produk,id',
        ]);

        $produk = null;
        if ($request->filled('produk_id')) {
            $produk = Produk::find($request->produk_id);
        }

        $keterangan = $request->keterangan;
        if ((!$keterangan || trim($keterangan) === '') && $produk && $produk->deskripsi) {
            $keterangan = $produk->deskripsi;
        }

        $penjualan = Penjualan::create([
            'cabang_id' => $request->cabang_id,
            'pengguna_id' => session('user.id'),
            'tanggal' => $request->tanggal,
            'total' => $request->total,
            'metode_pembayaran' => $request->metode_pembayaran,
            'keterangan' => $keterangan,
            'dibuat_oleh' => session('user.id'),
        ]);

        if ($produk) {
            DetailPenjualan::create([
                'penjualan_id' => $penjualan->id,
                'produk_id' => $produk->id,
                'jumlah' => 1,
                'harga' => $produk->harga,
            ]);
        }

        return redirect()->route('penjualan.index')->with('success', 'Transaksi berhasil ditambahkan');
    }

    public function show(string $id)
    {
        $penjualan = Penjualan::with(['cabang', 'pengguna', 'detail_penjualan.produk'])->findOrFail($id);
        return view('penjualan.show', compact('penjualan'));
    }

    public function edit(string $id)
    {
        $penjualan = Penjualan::findOrFail($id);
        $produk = Produk::where('status', 'aktif')->get();
        $cabang = Cabang::all();
        return view('penjualan.edit', compact('penjualan', 'produk', 'cabang'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'cabang_id' => 'required|exists:cabang,id',
            'tanggal' => 'required|date',
            'total' => 'required|numeric',
            'metode_pembayaran' => 'required|string',
            'keterangan' => 'nullable|string',
        ]);

        $penjualan = Penjualan::findOrFail($id);
        $penjualan->update([
            'cabang_id' => $request->cabang_id,
            'tanggal' => $request->tanggal,
            'total' => $request->total,
            'metode_pembayaran' => $request->metode_pembayaran,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('penjualan.index')->with('success', 'Transaksi berhasil diupdate');
    }

    public function destroy(string $id)
    {
        $penjualan = Penjualan::findOrFail($id);
        $penjualan->delete();

        return redirect()->route('penjualan.index')->with('success', 'Transaksi berhasil dihapus');
    }
}
