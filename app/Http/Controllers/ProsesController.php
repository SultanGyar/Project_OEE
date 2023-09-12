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
       $request->validate([
        'daftarproses' => 'required'
       ]);

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
        if (!$proses) return redirect()->route('proses.index')->with('error_message', 'Proses dengan id' .$id. ' tidak ditemukan');
        return view('proses.index', [
            'proses' => $proses
        ]);
    }


    /**
     * Update the specified resource in storage.
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */ 
    public function update(Request $request, string $id) 
    {
        $request->validate([
            'daftarproses' => 'required'
        ]);

        $proses = Proses::find($id);
        $proses->daftarproses = $request->daftarproses;
        $proses->save();

        return redirect()->route('proses.index')->with('success_message', 'Berhasil Mengupdate Proses');
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
