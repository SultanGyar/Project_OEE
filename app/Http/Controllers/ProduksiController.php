<?php

namespace App\Http\Controllers;

use App\Models\AnggotaKelompok;
use App\models\User;
use App\Models\Produksi;
use App\Models\Target;
use App\Models\Keterangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProduksiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
    
        if ($user->role === 'Operator') {
            // Jika pengguna adalah operator, hanya tampilkan data produksi mereka sendiri
            $produksi = Produksi::where('nama_user', $user->id)->get();
        } else {
            // Jika pengguna bukan operator, tampilkan semua data produksi
            $produksi = Produksi::all();
        }
    
        return view('produksi.index',[
            'produksi' => $produksi
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $allTargetProses = Target::pluck('daftarproses')->toArray();
        $produksiWithSameProses = Produksi::whereIn('daftarproses', $allTargetProses)->pluck('daftarproses')->toArray();
        $dataproses = Target::whereNotIn('daftarproses', $produksiWithSameProses)->pluck('daftarproses', 'daftarproses');

        return view('produksi.create', [
            'dataproses' => $dataproses,
            'dataketerangan' => Keterangan::pluck('daftarketerangan', 'daftarketerangan'),
            'user' => User::all()
        ]);
    }

    public function getTargetQuantity(Request $request)
    {
        $proses = $request->input('daftarproses');
        $tanggal = $request->input('tanggal');
            
        $targetQuantity = DB::table('target')
            ->where('daftarproses', $proses)
            ->where('tanggal_target', $tanggal)
            ->value('target_quantity');
            
        return response()->json([
            'success' => true,
            'target_quantity' => $targetQuantity
        ]);
    }

    public function getKelompokData(Request $request)
    {
        $proses = $request->input('daftarproses');

        // Menggunakan model Eloquent AnggotaKelompok
        $anggotaKelompok = AnggotaKelompok::where('daftarproses', $proses)->first();

        if ($anggotaKelompok) {
            $datakelompok = $anggotaKelompok->daftarkelompok;

            return response()->json([
                'success' => true,
                'daftarkelompok' => $datakelompok
            ]);
        }

        return response()->json([
            'success' => false,
            'daftarkelompok' => null
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
            'daftarproses' => 'required',
            'daftarkelompok' => 'required',
            'target_quantity' => 'required',
            'quantity' => 'required',
            'finish_good' => 'required',
            'reject' => 'nullable',
            'daftarketerangan' => 'nullable',
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

        $quantity = $request->input('quantity');
        $finishGood = $request->input('finish_good');
        $reject = $request->input('reject') ?? 0; // Jika reject tidak ada, maka dianggap 0.
    
        // Periksa apakah jumlah finish_good dan reject sama dengan quantity
        if ($quantity != ($finishGood + $reject)) {
            return redirect()
                ->route('produksi.create') // Ubah ini sesuai dengan route untuk halaman create
                ->withInput() // Mengembalikan input yang sudah diisi sebelumnya
                ->withErrors([
                    'finish_good' => 'Peringatan: Ketidaksesuaian dengan Actual Quantity',
                    'reject' => 'Peringatan: Ketidaksesuaian dengan Actual Quantity',
                ]);
        }
        
        $array = $request->only([
            'daftarproses',
            'daftarkelompok',
            'target_quantity',
            'quantity',
            'finish_good',
            'reject',
            'daftarketerangan',
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
        $array['nama_user'] = $user->id;
        $produksi = Produksi::create($array);
        return redirect()->route('produksi.index')->with('success_message', 'Berhasil menambah data baru');
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
