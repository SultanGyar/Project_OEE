<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataProduksi extends Model
{
    use HasFactory;

    protected $table = 'data_produksi';

    protected $fillable = [
        'proses',
        'kelompokan',
        'target_quantity',
        'quantity',
        'finish_good',
        'reject',
        'operating_time',
        'actual_time',
        'down_time',
        'tanggal',
    ];
}
