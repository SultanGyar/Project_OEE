<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelompok extends Model
{
    use HasFactory;
    protected $table = 'kelompok';
    protected $fillable = [
        'nama_kelompok',
        'proses_kelompok'
    ];

    public function fproses(){
        return $this->belongsTo(Proses::class, 'proses_kelompok', 'daftarproses');
    }
}
