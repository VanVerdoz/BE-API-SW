<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{

    //REGISTER
    public function register(Request $request)
{
    $validated = $request->validate([
        'username' => 'required|unique:pengguna,username',
        'password' => 'required|min:6',
        'nama_lengkap' => 'required|string',
        'role'     => 'required|string',
    ]);

    $user = \App\Models\Pengguna::create([
        'username'     => $validated['username'],
        'password'     => \Illuminate\Support\Facades\Hash::make($validated['password']),
        'nama_lengkap' => $validated['nama_lengkap'],
        'role'         => $validated['role'],
    ]);

    return response()->json([
        'message' => 'User berhasil dibuat',
        'data'    => $user
    ]);
}

    // LOGIN
            public function login(Request $request)
        {
            $request->validate([
                'username' => 'required',
                'password' => 'required',
            ]);

            $credentials = $request->only('username', 'password');

            if (!$token = auth()->attempt($credentials)) {
                return response()->json([
                    'message' => 'Username atau password salah'
                ], 401);
            }

            $pengguna = auth()->user();

            // CEK STATUS ACTIVE / INACTIVE
            if ($pengguna->status === 'inactive') {

                // Hapus token yang baru dibuat
                auth()->logout();

                return response()->json([
                    'message' => 'Akun anda tidak aktif'
                ], 403);
            }

            // Durasi token 1 hari
            $cookie = cookie(
            name: 'jwt_token',
            value: $token,
            minutes: 60 * 24,
            path: '/',
            // domain jangan dipaksa
            secure: false,        
            httpOnly: true,
            raw: false,
            sameSite: 'lax'       
);


            return response()->json([
                'message' => 'Login berhasil',
                'data' => [
                    'id' => $pengguna->id,
                    'nama_lengkap' => $pengguna->nama_lengkap,
                    'role' => $pengguna->role,
                ]
            ])->withCookie($cookie);
        }

    // LOGOUT: hapus cookie
    public function logout()
    {
        try {
            auth()->logout();
        } catch (\Exception $e) {
            
        }

        // HAPUS cookie jwt_token
        $deleteCookie = cookie()->forget('jwt_token');

        return response()->json(['message' => 'Logout berhasil'])
            ->withCookie($deleteCookie);
    }

    
}
