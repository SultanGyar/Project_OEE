<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

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

    protected static function boot()
    {
        parent::boot();
    
        static::creating(function ($model) {
            $url = 'http://oee.fajarbenua.co.id/produksi/create/' . $model->kode;
            $qrCode = QrCode::size(40)->generate($url);
            $model->qr = $qrCode;
        });

        static::updating(function ($model) {
            $url = 'http://oee.fajarbenua.co.id/produksi/create/' . $model->kode;
            $qrCode = QrCode::size(40)->generate($url);
            $model->qr = $qrCode;
        });
    }

    public function fproses()
    {
        return $this->belongsTo(Proses::class, 'daftarproses', 'daftarproses');
    }
}
