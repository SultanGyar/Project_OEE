<?php

namespace App\Http\Controllers;

use App\Models\Kelompok;
use App\Models\Proses;
use Illuminate\Http\Request;

use function PHPUnit\Framework\returnSelf;

class KelompokController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dataproses = Proses::pluck('daftarproses', 'daftarproses');
        $kelompok = Kelompok::all();
        return view('kelompok.index', compact('dataproses'),
        [
            'kelompok' => $kelompok
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_kelompok' => 'required',
            'proses_kelompok' => 'required'
        ]);

        $namaKelompok = $request->input('nama_kelompok');
        $prosesKelompok = $request->input('proses_kelompok');
        
        // Check if the combination of kelompok and proses_kelompok already exists
        $existingKelompok = Kelompok::where('nama_kelompok', $namaKelompok)
            ->where('proses_kelompok', $prosesKelompok)
            ->first();
        
        if ($existingKelompok) {
            // If the combination already exists, show a warning notification
            return redirect()->route('kelompok.index')
                ->with('warning_message', 'Maaf, data tidak dapat disimpan karena data dengan kelompok yang sama telah ada dalam sistem untuk proses tersebut.');
        }
        $array = $request->only([
            'nama_kelompok',
            'proses_kelompok'
        ]);
        $kelompok = Kelompok::create($array);
        return redirect()->route('kelompok.index')->with('success_message', 'Berhasil menambahkan anggota baru');
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
        $kelompok = Kelompok::find($id);
        if (!$kelompok) return redirect()-> route('kelompok.index')->with('error_message', 'Anggota dengan' .$id. 'tidak ditemukan');
        $dataproses = Proses::pluck('daftarproses', 'daftarproses');
        return view('kelompok.edit', compact('kelompok', 'dataproses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_kelompok' => 'required',
            'proses_kelompok' => 'required'
        ]);

        $namaKelompok = $request->input('nama_kelompok');
        $prosesKelompok = $request->input('proses_kelompok');
        
        // Check if the combination of kelompok and proses_kelompok already exists
        $existingKelompok = Kelompok::where('nama_kelompok', $namaKelompok)
            ->where('proses_kelompok', $prosesKelompok)
            ->where('id', '<>', $id)
            ->first();
        
        if ($existingKelompok) {
            // If the combination already exists, show a warning notification
            return redirect()->route('kelompok.index')
                ->with('warning_message', 'Tidak dapat menyimpan data tersebut, karena memiliki kesamaan dengan data yang sudah ada');
        }
        $kelompok = Kelompok::findOrFail($id);
        $kelompok->update([
            'nama_kelompok' => $namaKelompok,
            'proses_kelompok' => $prosesKelompok,
        ]);

        return redirect()->route('kelompok.index')->with('success_message', 'Berhasil menambahkan anggota baru');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $kelompok = Kelompok::find($id);
        if ($kelompok) $kelompok->delete();
        return redirect()->route('kelompok.index')->with('success_message', 'Berhasil menghapus Anggota');
    }
}
