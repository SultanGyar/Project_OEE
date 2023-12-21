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
        $message = [
            'required' => 'Kolom harus diisi',
        ];
        
        $request->validate([
            'daftarkelompok' => 'required',
            'daftarproses' => [
                'required',
                function ($attribute, $value, $fail) {
                    $sudahAda = AnggotaKelompok::where('daftarproses', $value)->first();
                    
                    if ($sudahAda) {
                        $fail(__('Proses sudah terdaftar pada kelompok lain'));
                    }
                },
            ],
        ], $message);
        
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
        $message = [
            'required' => 'Kolom harus diisi',
        ];
    
        $request->validate([
            'daftarkelompok' => 'required',
            'daftarproses' => [
                'required',
                function ($attribute, $value, $fail) use ($id, $request) {
                    $existingAnggotaKelompok = AnggotaKelompok::where('daftarproses', $value)
                        ->where('daftarkelompok', $request->input('daftarkelompok'))
                        ->where('id', '<>', $id)
                        ->first();
    
                    if ($existingAnggotaKelompok) {
                        $fail(__('Proses sudah terdaftar pada kelompok lain'));
                    }
                },
            ],
        ], $message);
    
        $dataKelompok = $request->input('daftarkelompok');
        $prosesKelompok = $request->input('daftarproses');
    
        $anggotaKelompok = AnggotaKelompok::findOrFail($id);
        $anggotaKelompok->update([
            'daftarkelompok' => $dataKelompok,
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