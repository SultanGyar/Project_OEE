<?php

namespace App\Http\Controllers;

use App\Imports\UserImport;
use App\Models\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Exceptions\LaravelExcelException;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        return view('users.index', [
            'users' => $users
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $message = [
            'name.required' => 'Nama harus diisi',
            'name.unique' => 'Nama sudah terdaftar dalam sistem',
            'full_name.required' => 'Nama Lengkap harus diisi',
            'full_name.unique' => 'Nama sudah terdaftar dalam sistem',
            'password.required' => 'Kata sandi harus diisi',
            'password.confirmed' => 'Kata sandi tidak cocok'
        ];

        $request->validate([
            'name' => 'required|unique:users,name',
            'full_name' => 'required|unique:users,full_name',
            'password' => 'required|confirmed',
            'role' => 'required',
        ], $message);

        $array = $request->only([
            'name', 'full_name', 'password', 'role'
        ]);

        $array['password'] = bcrypt($array['password']);
        $user = User::create($array);
        return redirect()->route('users.index')->with('success_message', 'Berhasil menambah user baru');
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
        $user = User::find($id);

        if (!$user) {
            return redirect()->route('users.index')->with('error_message', 'User dengan ID ' . $id . ' tidak ditemukan');
        }

        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $message = [
            'name.required' => 'Nama harus diisi',
            'name.unique' => 'Nama sudah terdaftar dalam sistem',
            'full_name.required' => 'Nama Lengkap harus diisi',
            'full_name.unique' => 'Nama sudah terdaftar dalam sistem',
            'password.required' => 'Kata sandi harus diisi',
            'password.confirmed' => 'Kata sandi tidak cocok'
        ];
        $request->validate([
            'name' => 'required|unique:users,name,' . $id,
            'full_name' => 'required|unique:users,full_name,' . $id,
            'password' => 'sometimes|nullable|confirmed',
            'role' => 'required'
        ], $message);

        $user = User::find($id);

        if (!$user) {
            return redirect()->route('users.index')->with('error_message', 'Pengguna dengan ID ' . $id . ' tidak ditemukan');
        }

        $userData = $request->only([
            'name',
            'full_name', 
            'role'
        ]);

        if ($request->filled('password')) {
            $userData['password'] = bcrypt($request->input('password'));
        }

        $user->update($userData);

        return redirect()->route('users.index')->with('success_message', 'Berhasil memperbarui pengguna');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        //Menghapus User
        $user = User::find($id);

        if ($id == $request->user()->id) return redirect()->route('users.index')->with('error_message', 'Anda tidak dapat menghapus diri sendiri.');
        if ($user) $user->delete();
        return redirect()->route('users.index')->with('success_message', 'Berhasil menghapus pengguna');
    }

    public function import(Request $request)
    {
        try {
            $file = $request->file('file');
            $namafile = $file->getClientOriginalName();
            $file->move('fileImportUser', $namafile);
        
            Excel::import(new UserImport, public_path('/fileImportUser/' . $namafile));

            return redirect()->route('users.index')->with('success_message', 'Berhasil Meng-Import data');
        } catch (LaravelExcelException $e) {
            // Tangkap kesalahan yang disebabkan oleh Excel Import
            return redirect()->route('users.index')->with('error_message', 'Gagal meng-import data. Pastikan format file Excel sesuai.');
        } catch (\Exception $e) {
            // Tangkap kesalahan umum lainnya
            return redirect()->route('users.index')->with('error_message', 'Terjadi kesalahan saat meng-import data.');
        }
    }
}
