<?php

namespace App\Http\Controllers;

use App\Models\Keterangan;
use Illuminate\Http\Request;

class KeteranganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $keterangan = Keterangan::all();
        return view('keterangan.index', [
            'keterangan' => $keterangan
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('keterangan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $message = [
            'required' => 'Kolom harus diisi',
            'unique' => 'Keterangan sudah terdaftar dalam sistem',
        ];

        $request->validate([
            'daftarketerangan' => 'required|unique:keterangan,daftarketerangan'
        ], $message);
    
        $daftarketerangan = $request->input('daftarketerangan');

        $keterangan = Keterangan::create([
            'daftarketerangan' => $daftarketerangan
        ]);
        return redirect()->route('keterangan.index')->with('success_message', 'Berhasil Menambahkan Keterangan Baru');
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
        $keterangan = Keterangan::find($id);

        if (!$keterangan) {
            return redirect()->route('keterangan.index')->with('error_message', 'Proses tidak ditemukan');
        }
        return view('keterangan.edit', [
            'keterangan' => $keterangan
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $message = [
            'required' => 'Kolom harus diisi',
            'unique' => 'Keterangan sudah terdaftar dalam sistem',
        ];

        $request->validate([
            'daftarketerangan' => 'required|unique:keterangan,daftarketerangan'
        ], $message);

        $keterangan = Keterangan::find($id);
        if (!$keterangan) {
            return redirect()->route('keterangan.index')->with('error_message', 'Keterangan tidak ditemukan');
        }

        $keterangan->daftarketerangan = $request->input('daftarketerangan');
        $keterangan->save();


        return redirect()->route('keterangan.index')->with('success_message', 'keterangan Berhasil diperbarui.');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $keterangan = Keterangan::find($id);
        if ($keterangan) {
            $keterangan->delete();
            return redirect()->route('keterangan.index')->with('success_message', 'Berhasil menghapus Keterangan');
        } else {
            return redirect()->route('keterangan.index')->with('error_message', 'Keterangan dengan id = ' . $id . ' tidak ditemukan');
        }
    }
}
