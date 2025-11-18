<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class ProfileController extends Controller
{
    // ================================
    // GET PROFILE
    // ================================
    public function show(Request $request)
    {
        return response()->json([
            'message' => 'Data profil',
            'data' => $request->user()
        ]);
    }

    // ================================
    // UPDATE PROFILE (username & nama)
    // ================================
    public function update(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'username'      => 'sometimes|string|max:50|unique:pengguna,username,' . $user->id,
            'nama_lengkap'  => 'sometimes|string|max:100',
        ]);

        $user->update($validated);

        return response()->json([
            'message' => 'Profil berhasil diperbarui',
            'data' => $user
        ]);
    }

    // ================================
    // RESET PASSWORD (seperti yang kamu mau)
    // ================================
    public function updatePassword(Request $request)
    {
        // VALIDASI REQUEST
        $request->validate([
            'nama_lengkap'   => 'required|string',
            'password_lama'  => 'required',
            'password_baru'  => 'required|min:6'
        ]);

        // AMBIL TOKEN DARI COOKIE
        $token = $request->cookie('jwt_token');

        if (!$token) {
            return response()->json([
                'message' => 'Token JWT tidak ditemukan'
            ], 401);
        }

        // AUTENTIKASI USER DARI JWT
        try {
            $user = JWTAuth::setToken($token)->authenticate();
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Token tidak valid atau kedaluwarsa'
            ], 401);
        }

        // CEK: nama_lengkap HARUS sesuai user login
        if ($request->nama_lengkap !== $user->nama_lengkap) {
            return response()->json([
                'message' => 'Anda tidak boleh mereset password milik pengguna lain'
            ], 403);
        }

        // CEK PASSWORD LAMA
        if (!Hash::check($request->password_lama, $user->password)) {
            return response()->json([
                'message' => 'Password lama salah'
            ], 400);
        }

        // UPDATE PASSWORD
        $user->password = Hash::make($request->password_baru);
        $user->save();

        return response()->json([
            'message' => 'Password berhasil direset'
        ]);
    }
    public function logout(Request $request)
    {
        // Hapus cookie jwt_token
        $deleteCookie = cookie()->forget('jwt_token');

        return response()->json([
            'message' => 'Logout berhasil, silakan login kembali.'
        ])->withCookie($deleteCookie);
    }

}
