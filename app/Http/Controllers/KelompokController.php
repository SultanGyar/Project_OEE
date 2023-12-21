<?php

namespace App\Http\Controllers;

use App\Models\Kelompok;
use Illuminate\Http\Request;

use function PHPUnit\Framework\returnSelf;

class KelompokController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kelompok = Kelompok::all();
        return view('kelompok.index', [
            'kelompok' => $kelompok
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('kelompok.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $message = [
            'required' => 'Kolom harus diisi',
            'unique' => 'Kelompok sudah terdaftar dalam sistem',
        ];

        $request->validate([
            'daftarkelompok' => 'required|unique:kelompok,daftarkelompok'
        ], $message);

        $array = $request->only([
            'daftarkelompok'
        ]);
        $kelompok = Kelompok::create($array);
        return redirect()->route('kelompok.index')->with('success_message', 'Berhasil menambahkan Kelompok baru');
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
        $kelompok = Kelompok::find($id);
        if (!$kelompok) {
            return redirect()->route('kelompok.index')->with('error_message', 'Kelompok tidak ditemukan');
        }

        return view('kelompok.edit', ['kelompok' => $kelompok]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $message = [
            'required' => 'Kolom harus diisi',
            'unique' => 'Kelompok sudah terdaftar dalam sistem',
        ];

        $request->validate([
            'daftarkelompok' => 'required|unique:kelompok,daftarkelompok,' . $id
        ], $message);

        $kelompok = Kelompok::find($id);
        if (!$kelompok) {
            return redirect()->route('kelompok.index')->with('error_message', 'Kelompok tidak ditemukan');
        }

        $kelompok->daftarkelompok = $request->input('daftarkelompok');
        $kelompok->save();

        return redirect()->route('kelompok.index')->with('success_message', 'Kelompok berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $kelompok = Kelompok::find($id);
        if ($kelompok) {
            $kelompok->delete();
            return redirect()->route('kelompok.index')->with('success_message', 'Berhasil menghapus kelompok');
        } else {
            return redirect()->route('kelompok.index')->with('error_message', 'Kelompok dengan id = ' . $id . ' tidak ditemukan');
        }
    }
}
