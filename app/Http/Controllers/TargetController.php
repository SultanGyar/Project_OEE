<?php

namespace App\Http\Controllers;

use App\Models\Target;
use Illuminate\Http\Request;

class TargetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $target = Target::all();
        return view('target.index', [
            'target' => $target
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('target.create');
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
        $target = Target::find($id);
        if ($target) $target->delete();
        return redirect()->route('target.index')->with('success_message', 'Berhasil menghapus Target');
    }
}