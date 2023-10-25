<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CycletimeProduk extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'cycletime_produk';
    protected $fillable = [
        'daftarproses',
        'size',
        'class',
        'kapasitas_pcs',
        'kode',
    ];
    
    public function fproses()
    {
        return $this->belongsTo(Proses::class, 'daftarproses', 'daftarproses');
    }
}