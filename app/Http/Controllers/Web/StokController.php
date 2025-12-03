<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StokController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->daftar();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return $this->buat();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return $this->simpan($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return $this->detail($id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return $this->ubah($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        return $this->perbarui($request, $id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return $this->hapus($id);
    }

    public function daftar(){}
    public function buat(){}
    public function simpan(Request $request){}
    public function detail(string $id){}
    public function ubah(string $id){}
    public function perbarui(Request $request, string $id){}
    public function hapus(string $id){}
}
