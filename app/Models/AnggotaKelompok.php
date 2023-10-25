<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AnggotaKelompok extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'anggota_kelompok';
    protected $fillable = [
        'daftarkelompok',
        'daftarproses'
    ];

    public function fkelompok(){
        return $this->belongsTo(Kelompok::class, 'daftarkelompok', 'daftarkelompok');
    }

    public function fproses(){
        return $this->belongsTo(Proses::class, 'daftarproses', 'daftarproses');
    }
}
