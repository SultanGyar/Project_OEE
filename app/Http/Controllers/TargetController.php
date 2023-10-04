<?php

namespace App\Http\Controllers;

use App\Models\Proses;
use App\Models\Target;
use Illuminate\Http\Request;

class TargetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dataproses = Proses::pluck('daftarproses', 'daftarproses');
        $target = Target::all();
        return view('target.index', compact('dataproses'),
        [
            'target' => $target
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
            'target_proses' => 'required',
            'tanggal_target' => 'required',
            'target_quantity_byadmin' => 'required'
        ]);

        $targetProses = $request->input('target_proses');
        $tanggalTarget = $request->input('tanggal_target');

        // Check if the combination of target_proses and tanggal_target already exists
        $existingTarget = Target::where('target_proses', $targetProses)
            ->where('tanggal_target', $tanggalTarget)
            ->first();

        if ($existingTarget) {
            // If the combination already exists, show a warning notification
            return redirect()->route('target.index')
                ->with('warning_message', 'Maaf, data tidak dapat disimpan karena data dengan proses yang sama telah ada dalam sistem untuk hari ini.');
        }
        $array = $request->only([
            'target_proses',
            'tanggal_target',
            'target_quantity_byadmin'
        ]);
        $target = Target::create($array);
        return redirect()->route('target.index')->with('success_message', 'Berhasil Menambahkan Target Baru');
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
        $target = Target::find($id);
        if (!$target) return redirect()->route('target.index')->with('error_message', 'Target dengan'.$id.' tidak ditemukan');
        $dataproses = Proses::pluck('daftarproses', 'daftarproses');
        return view('target.edit', compact('target', 'dataproses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'target_proses' => 'required',
            'tanggal_target' => 'required',
            'target_quantity_byadmin' => 'required'
        ]);

        $targetProses = $request->input('target_proses');
        $tanggalTarget = $request->input('tanggal_target');

        // Check if the combination of target_proses and tanggal_target already exists
        $existingTarget = Target::where('target_proses', $targetProses)
            ->where('tanggal_target', $tanggalTarget)
            ->where('id', '<>', $id) // Exclude the current record being edited
            ->first();

        if ($existingTarget) {
            // If the combination already exists, show a warning notification
            return redirect()->route('target.index')
                ->with('warning_message', 'Tidak dapat menyimpan data tersebut, karena Proses dan Tanggal memiliki kesamaan dengan data yang sudah ada');
        }

        $target = Target::findOrFail($id);
        $target->update([
            'target_proses' => $targetProses,
            'tanggal_target' => $tanggalTarget,
            'target_quantity_byadmin' => $request->input('target_quantity_byadmin')
        ]);

        return redirect()->route('target.index')->with('success_message', 'Berhasil Memperbarui Data Target');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $target = Target::find($id);
        if ($target) $target->delete();
        return redirect()->route('target.index')->with('success_message', 'Berhasil menghapus Target');
    }
}