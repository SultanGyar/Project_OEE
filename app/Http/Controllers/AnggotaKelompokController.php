<?php

namespace App\Http\Controllers;

use App\Models\AnggotaKelompok;
use App\Models\Kelompok;
use App\Models\Proses;
use Illuminate\Http\Request;

class AnggotaKelompokController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dataproses = Proses::pluck('daftarproses', 'daftarproses');
        $datakelompok = Kelompok::pluck('daftarkelompok', 'daftarkelompok');
        $anggota_kelompok = AnggotaKelompok::all();
        return view('anggota_kelompok.index', [
            'dataproses' => $dataproses,
            'datakelompok' => $datakelompok,
            'anggota_kelompok' => $anggota_kelompok
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('anggota_kelompok.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'daftarkelompok' => 'required',
            'daftarproses' => 'required'
        ]);
    
        $prosesKelompok = $request->input('daftarproses');
        
        $sudahAda = AnggotaKelompok::where('daftarproses', $prosesKelompok)
            ->first();
        
        if ($sudahAda) {
            return redirect()->route('anggota_kelompok.index')
                ->with('warning_message', 'Data tidak dapat disimpan karena proses sudah terdaftar pada kelompok lain');
        }
        
        $array = $request->only([
            'daftarkelompok',
            'daftarproses'
        ]);
    
        $anggotaKelompok = AnggotaKelompok::create($array);
        return redirect()->route('anggota_kelompok.index')->with('success_message', 'Berhasil menambahkan anggota baru');
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
        $anggotakelompok = AnggotaKelompok::find($id);
        
        if (!$anggotakelompok) {
            return redirect()->route('anggota_kelompok.index')->with('error_message', 'Anggota dengan ID ' . $id . ' tidak ditemukan');
        }
        
        $dataproses = Proses::pluck('daftarproses', 'daftarproses');
        return view('anggota_kelompok.edit', compact('anggotaKelompok', 'dataproses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'daftarkelompok' => 'required', // Anda juga bisa menambahkan validasi sesuai kebutuhan
            'daftarproses' => 'required',
        ]);
    
        $dataKelompok = $request->input('daftarkelompok');
        $prosesKelompok = $request->input('daftarproses');
    
        // Check if the combination of daftarkelompok and daftarproses already exists
        $existingAnggotaKelompok = AnggotaKelompok::where('daftarproses', $prosesKelompok)
            ->where('daftarkelompok', $dataKelompok)
            ->where('id', '<>', $id)
            ->first();
    
        if ($existingAnggotaKelompok) {
            // If the combination already exists, show a warning notification
            return redirect()->route('anggota_kelompok.index')
                ->with('warning_message', 'Data tidak dapat disimpan karena proses sudah terdaftar pada kelompok lain');
        }
    
        $anggotaKelompok = AnggotaKelompok::findOrFail($id);
        $anggotaKelompok->update([
            'daftarkelompok' => $dataKelompok, // Update kolom 'daftarkelompok'
            'daftarproses' => $prosesKelompok,
        ]);
    
        return redirect()->route('anggota_kelompok.index')->with('success_message', 'Berhasil mengupdate anggota');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $anggotaKelompok = AnggotaKelompok::find($id);

        if ($anggotaKelompok) {
            $anggotaKelompok->delete();
            return redirect()->route('anggota_kelompok.index')->with('success_message', 'Berhasil menghapus anggota');
        }

        return redirect()->route('anggota_kelompok.index')->with('error_message', 'Anggota dengan ID ' . $id . ' tidak ditemukan');
    }
}