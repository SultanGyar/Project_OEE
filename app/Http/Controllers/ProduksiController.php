<?php

namespace App\Http\Controllers;

use App\Imports\ProduksiImport;
use App\Models\AnggotaKelompok;
use App\Models\CycletimeProduk;
use App\models\User;
use App\Models\Produksi;
use App\Models\Keterangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Exceptions\LaravelExcelException;
use Maatwebsite\Excel\Facades\Excel;

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
            $produksi = Produksi::where('nama_user', $user->full_name)->get();
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
        $datakode = CycletimeProduk::pluck('kode', 'kode');
        $dataketerangan = Keterangan::pluck('daftarketerangan', 'daftarketerangan');
        return view('produksi.create', [
            'datakode' => $datakode,
            'dataketerangan' => $dataketerangan,
            'user' => User::all()
        ]);
    }

    public function getDataAuto(Request $request)
    {
        $response = [
            'success' => false,
            'daftarproses' => null,
            'kapasitas_pcs' => null,
            'produk_size' => null,
            'produk_class' => null,
            'daftarkelompok' => null,
        ];
    
        // Cek parameter kode
        $kode = $request->input('kode');
    
        // Mengecek jenis permintaan berdasarkan parameter yang ada
        if (!empty($kode)) {
            // Menggunakan model Eloquent CycletimeProduk
            $produk = CycletimeProduk::where('kode', $kode)->first();
            if ($produk) {
                $response['daftarproses'] = $produk->daftarproses;
                $response['kapasitas_pcs'] = $produk->kapasitas_pcs;
                $response['produk_size'] = $produk->size;
                $response['produk_class'] = $produk->class;
                $response['success'] = true;
            }
            
            // Identifikasi kesamaan dengan AnggotaKelompok
            if (!empty($response['daftarproses'])) {
                $anggotaKelompok = AnggotaKelompok::where('daftarproses', $response['daftarproses'])->first();
                if ($anggotaKelompok) {
                    $response['daftarkelompok'] = $anggotaKelompok->daftarkelompok;
                }
            }
        }
    
        return response()->json($response);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //menyimpan  produksi
        $user = auth()->user();
        $request->validate([
            'tanggal' => 'required',
            'kapasitas_pcs' => 'required',
            'target_quantity' => 'required',
            'daftarproses' => 'required',
            'daftarkelompok' => 'required',
            'produk_size' => 'required',
            'produk_class' => 'required',
            'kode' => 'required',
            'quantity' => 'required',
            'finish_good' => 'required',
            'reject' => 'nullable',
            'daftarketerangan' => 'nullable',
            'operating_start_time' => 'required',
            'operating_end_time' => 'required',
            'operating_time' => 'required',
            'down_time' => 'nullable',
            'actual_time' => 'required',
            'a_time' => 'nullable',
            'b_time' => 'nullable',
            'c_time' => 'nullable',
            'd_time' => 'nullable',
            'e_time' => 'nullable',
            'f_time' => 'nullable',
            'g_time' => 'nullable',
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
            'tanggal',
            'kapasitas_pcs',
            'target_quantity',
            'daftarproses',
            'daftarkelompok',
            'produk_size',
            'produk_class',
            'kode',
            'quantity',
            'finish_good',
            'reject',
            'daftarketerangan',
            'operating_start_time',
            'operating_end_time',
            'operating_time',
            'down_time',
            'actual_time',
            'a_time',
            'b_time',
            'c_time',
            'd_time',
            'e_time',
            'f_time',
            'g_time',
            'h_time'
        ]);
        $array['nama_user'] = auth()->user()->full_name;
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
    public function edit($id)
    {
        $produksi = Produksi::findOrFail($id); // Temukan data produksi berdasarkan ID yang diberikan
        $datakode = CycletimeProduk::pluck('kode', 'kode');
        $dataketerangan = Keterangan::pluck('daftarketerangan', 'daftarketerangan');

        return view('produksi.edit', [
            'produksi' => $produksi,
            'datakode' => $datakode,
            'dataketerangan' => $dataketerangan,
            'user' => User::all()
        ]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $user = auth()->user();
        $request->validate([
            'nama_user' => 'required',
            'tanggal' => 'required',
            'kapasitas_pcs' => 'required',
            'target_quantity' => 'required',
            'daftarproses' => 'required',
            'daftarkelompok' => 'required',
            'produk_size' => 'required',
            'produk_class' => 'required',
            'kode' => 'required',
            'quantity' => 'required',
            'finish_good' => 'required',
            'reject' => 'nullable',
            'daftarketerangan' => 'nullable',
            'operating_start_time' => 'required',
            'operating_end_time' => 'required',
            'operating_time' => 'required',
            'down_time' => 'nullable',
            'actual_time' => 'required',
            'a_time' => 'nullable',
            'b_time' => 'nullable',
            'c_time' => 'nullable',
            'd_time' => 'nullable',
            'e_time' => 'nullable',
            'f_time' => 'nullable',
            'g_time' => 'nullable',
            'h_time' => 'nullable'
        ]);
    
        $quantity = $request->input('quantity');
        $finishGood = $request->input('finish_good');
        $reject = $request->input('reject') ?? 0; // Jika reject tidak ada, maka dianggap 0.
    
        // Periksa apakah jumlah finish_good dan reject sama dengan quantity
        if ($quantity != ($finishGood + $reject)) {
            return redirect()
                ->route('produksi.edit', $id) // Ubah ini sesuai dengan route untuk halaman edit
                ->withInput() // Mengembalikan input yang sudah diisi sebelumnya
                ->withErrors([
                    'finish_good' => 'Peringatan: Ketidaksesuaian dengan Actual Quantity',
                    'reject' => 'Peringatan: Ketidaksesuaian dengan Actual Quantity',
                ]);
        }
    
        $produksi = Produksi::findOrFail($id);
        $produksi->update([
            'nama_user' => $request->input('nama_user'),
            'tanggal' => $request->input('tanggal'),
            'kapasitas_pcs' => $request->input('kapasitas_pcs'),
            'target_quantity' => $request->input('target_quantity'),
            'daftarproses' => $request->input('daftarproses'),
            'daftarkelompok' => $request->input('daftarkelompok'),
            'produk_size' => $request->input('produk_size'),
            'produk_class' => $request->input('daftarkelompok'),
            'kode' => $request->input('kode'),
            'quantity' => $request->input('quantity'),
            'finish_good' => $request->input('finish_good'),
            'reject' => $request->input('reject'),
            'daftarketerangan' => $request->input('daftarketerangan'),
            'operating_start_time' => $request->input('operating_start_time'),
            'operating_end_time' => $request->input('operating_end_time'),
            'operating_time' => $request->input('operating_time'),
            'down_time' => $request->input('down_time'),
            'actual_time' => $request->input('actual_time'),
            'a_time' => $request->input('a_time'),
            'b_time' => $request->input('b_time'),
            'c_time' => $request->input('c_time'),
            'd_time' => $request->input('d_time'),
            'e_time' => $request->input('e_time'),
            'f_time' => $request->input('f_time'),
            'g_time' => $request->input('g_time'),
            'h_time' => $request->input('h_time')
        ]);
    
        return redirect()->route('produksi.index')->with('success_message', 'Berhasil memperbarui data');
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

    public function import(Request $request)
    {
        try {
            $file = $request->file('file');
            $namafile = $file->getClientOriginalName();
            $file->move('fileImportProduksi', $namafile);
        
            Excel::import(new ProduksiImport, public_path('/fileImportProduksi/' . $namafile));

            return redirect()->route('produksi.index')->with('success_message', 'Berhasil Meng-Import data');
        } catch (LaravelExcelException $e) {
            // Tangkap kesalahan yang disebabkan oleh Excel Import
            return redirect()->route('produksi.index')->with('error_message', 'Gagal meng-import data. Pastikan format file Excel sesuai.');
        } catch (\Exception $e) {
            // Tangkap kesalahan umum lainnya
            return redirect()->route('produksi.index')->with('error_message', 'Terjadi kesalahan saat meng-import data.');
        }
    }
}
