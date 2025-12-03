<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Penjualan;
use App\Models\DetailPenjualan;
use App\Models\Cabang;
use App\Models\Pengguna;

class PermintaanStokController extends Controller
{
    public function create()
    {
        return $this->buat();
    }

    public function store(Request $request)
    {
        return $this->simpan($request);
    }

    public function approve($id)
    {
        if (session('user.role') !== 'kepala_gudang') {
            abort(403, 'Hanya Kepala Gudang yang dapat menyetujui permintaan.');
        }

        $req = Penjualan::where('id', $id)
            ->where('metode_pembayaran', 'request_stok')
            ->firstOrFail();

        $note = trim((string)$req->keterangan);
        if ($note !== '') {
            $note .= ' | Disetujui Kepala Gudang pada ' . now()->format('d/m/Y H:i');
        } else {
            $note = 'Disetujui Kepala Gudang pada ' . now()->format('d/m/Y H:i');
        }

        $req->keterangan = $note;
        $req->metode_pembayaran = 'request_stok_approved';
        $req->save();

        return back()->with('success', 'Permintaan stok disetujui.');
    }

    public function destroy($id)
    {
        return $this->hapus($id);
    }

    public function buat()
    {
        if (session('user.role') !== 'raider') {
            abort(403);
        }
        $produk = Produk::all();
        $cabang = Cabang::all();
        return view('raider.permintaan-stok', compact('produk', 'cabang'));
    }

    public function simpan(Request $request)
    {
        if (session('user.role') !== 'raider') {
            abort(403);
        }

        $request->validate([
            'cabang_id'   => 'required|exists:cabang,id',
            'produk_id'   => 'required|array|min:1',
            'produk_id.*' => 'required|exists:produk,id',
            'jumlah'      => 'required|array|min:1',
            'jumlah.*'    => 'required|integer|min:1',
            'catatan'     => 'nullable|string',
        ]);

        $userIdRaw    = session('user.id');
        $userNama     = session('user.nama_lengkap') ?? null;
        $userUsername = session('user.username') ?? null;
        $displayNama  = $userNama ?: ($userUsername ?: $userIdRaw);

        $catatan = trim((string) $request->catatan);
        $keterangan = 'Permintaan stok oleh: ' . $displayNama;
        if ($catatan !== '') {
            $keterangan .= ' | Catatan: ' . $catatan;
        }

        $penggunaId = null;
        if (!is_null($userIdRaw) && is_numeric($userIdRaw)) {
            $penggunaId = (int) $userIdRaw;
        } else {
            if ($userUsername) {
                $pengguna = Pengguna::where('username', $userUsername)->first();
                if ($pengguna && is_numeric($pengguna->id)) {
                    $penggunaId = (int) $pengguna->id;
                }
            }
        }

        if (is_null($penggunaId)) {
            return back()->withErrors([
                'pengguna_id' => 'ID pengguna untuk akun yang login tidak sesuai dengan struktur database.'
            ])->withInput();
        }

        $penjualan = Penjualan::create([
            'cabang_id'         => $request->cabang_id,
            'pengguna_id'       => $penggunaId,
            'tanggal'           => now(),
            'total'             => 0,
            'metode_pembayaran' => 'request_stok',
            'keterangan'        => $keterangan,
            'dibuat_oleh'       => $penggunaId,
        ]);

        foreach ($request->produk_id as $index => $produkId) {
            $jumlah = $request->jumlah[$index] ?? null;
            if (!$produkId || !$jumlah) {
                continue;
            }

            DetailPenjualan::create([
                'penjualan_id' => $penjualan->id,
                'produk_id'    => $produkId,
                'jumlah'       => $jumlah,
                'harga'        => 0,
            ]);
        }

        return redirect()->route('dashboard')
            ->with('success', 'Permintaan stok berhasil dikirim ke Kepala Gudang.');
    }

    public function hapus($id)
    {
        if (session('user.role') !== 'kepala_gudang') {
            abort(403);
        }

        $req = Penjualan::findOrFail($id);
        DetailPenjualan::where('penjualan_id', $req->id)->delete();
        $req->delete();

        return back()->with('success', 'Permintaan stok dihapus.');
    }
}
