<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Milon\Barcode\DNS2D;

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

    public static function boot()
    {
        parent::boot();

        // Trigger updating event for existing records
        static::all()->each(function ($model) {
            $model->update([]);
        });

        // Register the creating and updating events
        static::creating(function ($model) {
            $url = 'http://oee.fajarbenua.co.id:153/produksi/create/' . $model->kode;
            $barcode = new DNS2D();
            $barcode->setStorPath(__DIR__.'/cache/');
            $qrCode = $barcode->getBarcodeSVG($url, 'QRCODE', 1.2, 1.2);
            $model->qr = $qrCode;
        });

        static::updating(function ($model) {
            $url = 'http://oee.fajarbenua.co.id:153/produksi/create/' . $model->kode;
            $barcode = new DNS2D();
            $barcode->setStorPath(__DIR__.'/cache/');
            $qrCode = $barcode->getBarcodeSVG($url, 'QRCODE', 1.2, 1.2);
            $model->qr = $qrCode;
        });
    }

    public function fproses()
    {
        return $this->belongsTo(Proses::class, 'daftarproses', 'daftarproses');
    }
}
