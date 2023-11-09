<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User;
use Illuminate\Contracts\Auth\Authenticatable;

class Produksi extends Model
{
    use HasFactory;
    protected $table = 'produksi';
    protected $fillable = [
        'nama_user',
        'daftarproses',
        'tanggal',
        'kapasitas_pcs',
        'target_quantity',
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
    ];

    public function fuser(){
        return $this->belongsTo(User::class, 'nama_user', 'full_name');
    }


    public function fketerangan(){
        return $this->belongsTo(Keterangan::class, 'daftarketerangan', 'daftarketerangan');
    }
    
}
