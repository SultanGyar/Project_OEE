<?php

namespace App\Http\Controllers;

use App\Models\Proses;
use App\Models\CycletimeProduk;
use Illuminate\Http\Request;

class CycletimeProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dataproses = Proses::pluck('daftarproses', 'daftarproses');
        $produk = CycletimeProduk::all();
        return view('cycletime_produk.index', [
            'dataproses' => $dataproses,
            'produk' => $produk
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // return view('target.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'daftarproses' => 'required',
            'size' => 'required',
            'class' => 'required',
            'kapasitas_pcs' => 'required',
            'kode' => 'required|unique:cycletime_produk,kode', // Unik berdasarkan tabel cycletime_produk
        ]);

        $array = $request->only([
            'daftarproses',
            'size',
            'class',
            'kapasitas_pcs',
            'kode'
        ]);
        $produk = CycletimeProduk::create($array);
        return redirect()->route('cycletime_produk.index')->with('success_message', 'Berhasil Menambahkan data Baru');
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
    public function edit($id)
    {
        $produk = CycletimeProduk::find($id);
        if (!$produk) return redirect()->route('cycletime_produk.index')->with('error_message', 'Data dengan'.$id.' tidak ditemukan');
        $dataproses = Proses::pluck('daftarproses', 'daftarproses');
        return view('cycletime_produk.edit', 
        [
            'produk' => $produk,
            'dataproses' => $dataproses
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'daftarproses' => 'required',
            'size' => 'required',
            'class' => 'required',
            'kapasitaas_pcs' => 'required',
            'kode' => 'required'
        ]);

        $produk = CycletimeProduk::findOrFail($id);
        $produk->update([
            'daftar_proses' => $request->input('daftar_proses'),
            'size' => $request->input('size'),
            'class' => $request->input('class'),
            'kapasitas_shift' => $request->input('kapasitas_pcs'),
            'kode' => $request->input('kode')
        ]);

        return redirect()->route('cycletime_produk.index')->with('success_message', 'Berhasil Memperbarui Data Produk');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $produk = CycletimeProduk::find($id);
        if ($produk) $produk->delete();
        return redirect()->route('cycletime_produk.index')->with('success_message', 'Berhasil menghapus Produk');
    }
}