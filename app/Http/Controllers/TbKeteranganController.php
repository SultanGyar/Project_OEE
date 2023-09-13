<?php

namespace App\Http\Controllers;

use App\Models\TbKeterangan;
use Illuminate\Http\Request;

class TbKeteranganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tbketerangan = TbKeterangan::all();
        return view('tbketerangan.index', [
            'tbketerangan' => $tbketerangan
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('tbketerangan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'daftarketerangan' => 'required'
        ]);
    
        $daftarketerangan = $request->input('daftarketerangan');

        $tbketerangan = TbKeterangan::create([
            'daftarketerangan' => $daftarketerangan
        ]);
        return redirect()->route('tbketerangan.index')->with('success_message', 'Berhasil Menambahkan Keterangan Baru');
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
        $tbketerangan = TbKeterangan::find($id);

        if (!$tbketerangan) {
            return redirect()->route('tbketerangan.index')->with('error_message', 'Proses tidak ditemukan');
        }
        return view('tbketerangan.edit', [
            'tbketerangan' => $tbketerangan
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'daftarketerangan' => 'required'
        ]);

        $tbketerangan = TbKeterangan::find($id);
        if (!$tbketerangan) {
            return redirect()->route('tbketerangan.index')->with('error_message', 'Proses tidak ditemukan');
        }

        $tbketerangan->daftarketerangan = $request->input('daftarketerangan');
        $tbketerangan->save();


        return redirect()->route('tbketerangan.index')->with('success_message', 'Keteranagan Berhasil diperbarui.');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $tbketerangan = TbKeterangan::find($id);
        if ($tbketerangan) {
            $tbketerangan->delete();
            return redirect()->route('tbketerangan.index')->with('success_message', 'Berhasil menghapus Keterangan');
        } else {
            return redirect()->route('tbketerangan.index')->with('error_message', 'Keterangan dengan id = ' . $id . ' tidak ditemukan');
        }
    }
}
