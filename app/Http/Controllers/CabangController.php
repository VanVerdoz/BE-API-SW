<?php

namespace App\Http\Controllers;

use App\Models\Cabang;
use Illuminate\Http\Request;

class CabangController extends Controller
{
    // GET semua cabang
    public function index()
    {
        return response()->json([
            'message' => 'Daftar cabang',
            'data' => Cabang::all()
        ]);
    }

    // POST tambah cabang
    public function store(Request $request)
    {
        $request->validate([
            'nama_cabang' => 'required|string|max:100',
            'alamat' => 'required|string',
            'status' => 'required|string',
        ]);

        $cabang = Cabang::create([
            'nama_cabang' => $request->nama_cabang,
            'alamat' => $request->alamat,
            'status' => $request->status,
            'created_at' => now(),
        ]);

        return response()->json([
            'message' => 'Cabang berhasil ditambahkan',
            'data' => $cabang
        ], 201);
    }

    // GET cabang by id
    public function show($id)
    {
        $cabang = Cabang::find($id);

        if (!$cabang) {
            return response()->json(['message' => 'Cabang tidak ditemukan'], 404);
        }

        return response()->json([
            'message' => 'Detail cabang',
            'data' => $cabang
        ]);
    }

    // PUT update cabang
    public function update(Request $request, $id)
    {
        $cabang = Cabang::find($id);

        if (!$cabang) {
            return response()->json(['message' => 'Cabang tidak ditemukan'], 404);
        }

        $request->validate([
            'nama_cabang' => 'string|max:100',
            'alamat' => 'string',
            'status' => 'string',
        ]);

        $cabang->update($request->all());

        return response()->json([
            'message' => 'Cabang berhasil diperbarui',
            'data' => $cabang
        ]);
    }

    // DELETE cabang
    public function destroy($id)
    {
        $cabang = Cabang::find($id);

        if (!$cabang) {
            return response()->json(['message' => 'Cabang tidak ditemukan'], 404);
        }

        $cabang->delete();

        return response()->json(['message' => 'Cabang berhasil dihapus']);
    }
}
