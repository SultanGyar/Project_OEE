<?php

namespace App\Http\Controllers;

use App\Imports\CycletimeProdukImport;
use App\Models\Proses;
use App\Models\CycletimeProduk;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Exceptions\LaravelExcelException;
use Maatwebsite\Excel\Facades\Excel;

class CycletimeProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $daftarprosesOptions = CycletimeProduk::distinct()->pluck('daftarproses');
        $produk = CycletimeProduk::all();
        $dataproses = Proses::pluck('daftarproses', 'daftarproses');

        return view('cycletime_produk.index', [
            'dataproses' => $dataproses,
            'produk' => $produk,
            'daftarprosesOptions' => $daftarprosesOptions,
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
            'kapasitas_pcs' => 'required',
            'kode' => 'required|unique:cycletime_produk,kode,' . $id
        ]);
    
        $produk = CycletimeProduk::findOrFail($id);
        $produk->daftarproses = $request->input('daftarproses');
        $produk->size = $request->input('size');
        $produk->class = $request->input('class');
        $produk->kapasitas_pcs = $request->input('kapasitas_pcs');
        $produk->kode = $request->input('kode');
        $produk->save();
    
        return redirect()->route('cycletime_produk.index')->with('success_message', 'Berhasil Memperbarui Data');
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

    public function import(Request $request)
    {
        try {
            $file = $request->file('file');
            $namafile = $file->getClientOriginalName();
            $file->move('fileImportCycletime', $namafile);

            Excel::import(new CycletimeProdukImport, public_path('/fileImportCycletime/' . $namafile));

            // The import was successful, no need to delete the file
            return redirect()->route('cycletime_produk.index')->with('success_message', 'Berhasil Meng-Import data');
        } catch (\Exception $e) {
            // Import failed, delete the file
            unlink(public_path('/fileImportCycletime/' . $namafile));

            if (strpos($e->getMessage(), 'Integrity constraint violation') !== false) {
                if (strpos($e->getMessage(), 'Cannot add or update a child row: a foreign key constraint fails') !== false) {
                    return redirect()->route('cycletime_produk.index')->with('error_message', 'Import Error: Terdapat nilai Proses yang tidak terdaftar pada Database');
                } else {
                    // Extract the duplicate value from the exception message
                    preg_match('/Duplicate entry \'(.*?)\' for key/', $e->getMessage(), $matches);
                    $duplicateValue = $matches[1] ?? '';

                    return redirect()->route('cycletime_produk.index')->with('error_message', 'Import Error: Terdapat nilai duplikat yaitu; ' . $duplicateValue . '. Pada file import');
                }
            } else {
                // Handle other exceptions
                return redirect()->route('cycletime_produk.index')->with('error_message','Terjadi kesalahan saat meng-import data.');
            }
        }
    }


   
    public function cetakQr(Request $request, $daftarproses)
    {
        // Mendapatkan semua data dengan nilai 'daftarproses' yang sama
        $dataproduk = CycletimeProduk::where('daftarproses', $daftarproses)->get();

        // Load view dan generate PDF
        $pdf = PDF::loadView('cycletime_produk.cetak', compact('dataproduk'));
        $pdf->setPaper('a4', 'portrait');

        // Menggunakan daftarproses sebagai bagian dari nama file PDF
        return $pdf->stream("Kode Qr {$daftarproses} - " . now()->format('Ymd') . ".pdf");
    }

    
}