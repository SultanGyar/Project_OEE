<?php

namespace App\Http\Controllers;

use App\models\User;
use App\Models\Produksi;
use App\Models\Proses;
use App\Models\TbKeterangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProduksiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $produksi = Produksi::all();
        return view('produksi.index', [
            'produksi' => $produksi
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $dataproses = Proses::pluck('daftarproses', 'daftarproses');
        $dataketerangan = TbKeterangan::pluck('daftarketerangan', 'daftarketerangan');
        return view(
            'produksi.create', compact('dataproses', 'dataketerangan'),
            [  
            'user' => User::all()
        ]);
    }

    public function getTargetQuantity(Request $request)
    {
        $proses = $request->input('proses');
        $tanggal = $request->input('tanggal');
            
        $targetQuantity = DB::table('target')
            ->where('target_proses', $proses)
            ->where('tanggal_target', $tanggal)
            ->value('target_quantity_byadmin');
            
        return response()->json([
            'success' => true,
            'target_quantity' => $targetQuantity
        ]);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //menyimpan  produksi
        $user = auth()->user();
        $request->validate([
            'proses' => 'required',
            'target_quantity' => 'required',
            'quantity' => 'required',
            'finish_good' => 'required',
            'reject' => 'required',
            'keterangan' => 'nullable',
            'tanggal' => 'required',
            'operating_start_time' => 'required',
            'operating_end_time' => 'required',
            'operating_time' => 'required',
            'down_time' => 'nullable',
            'actual_time' => 'required',
            'a_start_time' => 'nullable',
            'a_end_time' => 'nullable',
            'a_time' => 'nullable',
            'b_start_time' => 'nullable',
            'b_end_time' => 'nullable',
            'b_time' => 'nullable',
            'c_start_time' => 'nullable',
            'c_end_time' => 'nullable',
            'c_time' => 'nullable',
            'd_start_time' => 'nullable',
            'd_end_time' => 'nullable',
            'd_time' => 'nullable',
            'e_start_time' => 'nullable',
            'e_end_time' => 'nullable',
            'e_time' => 'nullable',
            'f_start_time' => 'nullable',
            'f_end_time' => 'nullable',
            'f_time' => 'nullable',
            'g_start_time' => 'nullable',
            'g_end_time' => 'nullable',
            'g_time' => 'nullable',
            'h_start_time' => 'nullable',
            'h_end_time' => 'nullable',
            'h_time' => 'nullable'
        ]);
        $array = $request->only([
            'proses',
            'target_quantity',
            'quantity',
            'finish_good',
            'reject',
            'keterangan',
            'tanggal',
            'operating_start_time',
            'operating_end_time',
            'operating_time',
            'down_time',
            'actual_time',
            'a_start_time',
            'a_end_time',
            'a_time',
            'b_start_time',
            'b_end_time',
            'b_time',
            'c_start_time',
            'c_end_time',
            'c_time',
            'd_start_time',
            'd_end_time',
            'd_time',
            'e_start_time',
            'e_end_time',
            'e_time',
            'f_start_time',
            'f_end_time',
            'f_time',
            'g_start_time',
            'g_end_time',
            'g_time',
            'h_start_time',
            'h_end_time',
            'h_time'
        ]);
        $array['nama_operator'] = $user->id;
        $produksi = Produksi::create($array);
        return redirect()->route('produksi.index')->with('success_message', 'Berhasil menambah produksi baru');
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
        $produksi = Produksi::find($id);
        if ($produksi) $produksi->delete();
        return redirect()->route('produksi.index')->with('success_message', 'Berhasil menghapus Produksi');
    }
}
