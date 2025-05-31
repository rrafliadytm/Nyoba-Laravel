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
    public function index(Request $request)

    {
        $data = mahasiswa::orderBy('nim', 'desc')->paginate(5);
        $katakunci = $request->get('katakunci');
        if ($katakunci) {
            $data = mahasiswa::where('nim', 'like', '%' . $katakunci . '%')
                ->orWhere('nama', 'like', '%' . $katakunci . '%')
                ->orWhere('jurusan', 'like', '%' . $katakunci . '%')
                ->orderBy('nim', 'asc')->paginate(5);
        } else {
            $data = mahasiswa::orderBy('nim', 'desc')->paginate(5);
        }
        if ($data->isEmpty()) {
            FacadesSession::flash('katakunci', $katakunci);
            return redirect()
                ->route('mahasiswa.index')
                ->with('failed', 'Data mahasiswa dengan kata kunci "' . $katakunci . '" tidak ditemukan!');
        }
        return view('mahasiswa.index', compact('data'))->with('data', $data);
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
        $data = mahasiswa::where('nim', $id)->first();
        return view('mahasiswa.edit')->with('data', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'nama' => 'required|string|max:255',
            'jurusan' => 'required|string|max:255',
        ], [
            'nama.required' => 'NAMA wajib diisi!',
            'jurusan.required' => 'JURUSAN wajib diisi!',
        ]);
        mahasiswa::where('nim', $id)->update($data);
        return redirect()->to('mahasiswa')->with('success', 'Data mahasiswa berhasil diubah!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        mahasiswa::where('nim', $id)->delete();
        return redirect()->to('mahasiswa')->with('success', 'Data mahasiswa berhasil dihapus!');
    }
}
