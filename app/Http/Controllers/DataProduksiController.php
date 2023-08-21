<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DataProduksi;

class DataProduksiController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data_produksi = DataProduksi::all();
        return view('data_produksi.index', compact('data_produksi'));
    }




    // Metode lain seperti create, store, edit, update, delete, dll.
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
        //
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
        //Menghapus Produksi
        $data_produksi = DataProduksi::find($id);
        if ($data_produksi) $data_produksi->delete();
        return redirect()->route('data_produksi.index')->with('success_message', 'Berhasil menghapus Data Produksi');
    }
}
