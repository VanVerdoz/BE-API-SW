<?php

namespace App\Http\Controllers;

use App\Models\Pengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PenggunaController extends Controller
{
    // === CREATE USER (hanya ADMIN) ===
    public function store(Request $request)
    {
        if ($request->user()->role !== 'admin') {
            return response()->json([
                'message' => 'Akses ditolak. Hanya admin yang boleh membuat pengguna.'
            ], 403);
        }

        $request->validate([
            'username' => 'required|unique:pengguna',
            'password' => 'required|min:6',
            'nama_lengkap' => 'required',
            'role' => 'required',
            'status' => 'required',
        ]);

        $data = $request->all();
        $data['password'] = Hash::make($request->password);

        $pengguna = Pengguna::create($data);

        return response()->json([
            'message' => 'Pengguna berhasil dibuat',
            'data' => $pengguna
        ], 201);
    }

    // === LIST USER (ADMIN & OWNER) ===
    public function index(Request $request)
    {
        if (!in_array($request->user()->role, ['admin', 'owner'])) {
            return response()->json([
                'message' => 'Akses ditolak. Hanya admin dan owner yang boleh melihat data pengguna.'
            ], 403);
        }

        return response()->json([
            'message' => 'Daftar pengguna',
            'data' => Pengguna::all()
        ]);
    }

    // === UPDATE USER (hanya ADMIN) ===
    public function update(Request $request, $id)
    {
        if ($request->user()->role !== 'admin') {
            return response()->json([
                'message' => 'Akses ditolak. Hanya admin yang boleh memperbarui pengguna.'
            ], 403);
        }

        $pengguna = Pengguna::findOrFail($id);

        if ($request->password) {
            $request['password'] = Hash::make($request->password);
        }

        $pengguna->update($request->all());

        return response()->json([
            'message' => 'Pengguna berhasil diperbarui',
            'data' => $pengguna
        ]);
    }

    // === DELETE USER (hanya ADMIN) ===
    public function destroy(Request $request, $id)
    {
        if ($request->user()->role !== 'admin') {
            return response()->json([
                'message' => 'Akses ditolak. Hanya admin yang boleh menghapus pengguna.'
            ], 403);
        }

        Pengguna::destroy($id);

        return response()->json(['message' => 'Pengguna dihapus']);
    }
}
