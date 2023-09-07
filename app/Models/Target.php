<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Target extends Model
{
    use HasFactory;
    protected $table = 'target';
    protected $fillable = [
        'target_proses',
        'tanggal_target',
        'target_quantity_byadmin'
    ];
    
    public function fproses(){
        return $this->belongsTo(Proses::class, 'target_proses', 'daftarproses');
    }
}