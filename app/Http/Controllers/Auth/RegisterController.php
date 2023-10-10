<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule; // Impor namespace Rule
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:100', 'unique:users'],
            'full_name' => ['required', 'string', 'max:120', 'unique:users'],
            'password' => ['required', 'string', 'min:5', 'confirmed'],
            'role' => [
                    'required',
                    Rule::in(['Admin', 'Operator']),
                    function ($attribute, $value, $fail) {
                        $maxAdminCount = 1; // Jumlah maksimal admin yang diizinkan
        
                        $adminCount = User::where('role', 'Admin')->count();
        
                        if ($value === 'Admin' && $adminCount >= $maxAdminCount) {
                            $fail('Batas jumlah admin telah tercapai.');
                        }
                    },
                ],
            'status' => ['required', Rule::in(['Aktif', 'Tidak Aktif'])],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'full_name' => $data['full_name'],
            'password' => Hash::make($data['password']),
            'role' => $data['role'],
            'status' => $data['status'],
        ]);
    }
}
