<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\mahasiswa; // Import the Mahasiswa model
use Illuminate\Contracts\Session\Session;
use Illuminate\Support\Facades\Session as FacadesSession;

class mahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = mahasiswa::orderBy('nim','desc')->paginate(10);
        return view('mahasiswa.index')->with('data', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('mahasiswa.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        FacadesSession::flash('nim', $request->nim);
        FacadesSession::flash('nama', $request->nama);
        FacadesSession::flash('jurusan', $request->jurusan);

        $data = $request->validate([
            'nim' => 'required|integer|unique:mahasiswa,nim',
            'nama' => 'required|string|max:255',
            'jurusan' => 'required|string|max:255',
        ], [
            'nim.required' => 'NIM wajib diisi!',
            'nim.integer' => 'NIM harus berupa angka!',
            'nim.unique' => 'NIM sudah digunakan!',
            'nama.required' => 'NAMA wajib diisi!',
            'jurusan.required' => 'JURUSAN wajib diisi!',
        ]);
        mahasiswa::create($data);
        return redirect()->to('mahasiswa')->with('success', 'Data mahasiswa berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
