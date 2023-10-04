<?php

namespace App\Http\Controllers;

use App\Models\Proses;
use Illuminate\Http\Request;

class ProsesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $proses = Proses::all();
        return view('proses.index', [
            'proses' => $proses
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('proses.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $message = [
            'daftarproses.required' => 'Nama Proses harus diisi',
            'daftarproses.unique' => 'Proses sudah terdaftar dalam sistem',
        ];

       $request->validate([
        'daftarproses' => 'required|unique:proses,daftarproses'
       ], $message);

       $array = $request->only([
        'daftarproses',
       ]);

       $proses = Proses::create($array);
       return redirect()->route('proses.index')->with('success_message', 'Berhasil Menambahkan Proses Baru');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $proses = Proses::find($id);
        if (!$proses) {
            return redirect()->route('proses.index')->with('error_message', 'Proses tidak ditemukan.');
        }

        return view('proses.edit', ['proses' => $proses]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $message = [
            'daftarproses.required' => 'Nama Proses harus diisi',
            'daftarproses.unique' => 'Proses sudah terdaftar dalam sistem',
        ];

        $request->validate([
            'daftarproses' => 'required|unique:proses,daftarproses'
        ], $message);

        $proses = Proses::find($id);
        if (!$proses) {
            return redirect()->route('proses.index')->with('error_message', 'Proses tidak ditemukan.');
        }

        $proses->daftarproses = $request->input('daftarproses');
        $proses->save();

        return redirect()->route('proses.index')->with('success_message', 'Proses berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $proses = Proses::find($id);
        if ($proses) {
            $proses->delete();
            return redirect()->route('proses.index')->with('success_message', 'Berhasil menghapus Proses');
        } else {
            return redirect()->route('proses.index')->with('error_message', 'Proses dengan id = ' . $id . ' tidak ditemukan');
        }
    }
}
