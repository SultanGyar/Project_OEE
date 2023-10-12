<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CycletimeProdukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'daftarproses' => 'Winding 7',
                'size' => '1"',
                'class' => '150 Basic',
                'kapasitas_pcs' => 39,
                'kode' => 'W703150'
            ],
            [
                'daftarproses' => 'Winding 7',
                'size' => '1 1/4"',
                'class' => '150 Basic',
                'kapasitas_pcs' => 32,
                'kode' => 'W704150'
            ],
            [
                'daftarproses' => 'Winding 7',
                'size' => '1 1/2"',
                'class' => '150 Basic',
                'kapasitas_pcs' => 30,
                'kode' => 'W705150'
            ],
            [
                'daftarproses' => 'Winding 7',
                'size' => '2"',
                'class' => '150 Basic',
                'kapasitas_pcs' => 29,
                'kode' => 'W706150'
            ],
            [
                'daftarproses' => 'Winding 7',
                'size' => '2 1/2"',
                'class' => '150 Basic',
                'kapasitas_pcs' => 30,
                'kode' => 'W707150'
            ],
            [
                'daftarproses' => 'Winding 7',
                'size' => '3"',
                'class' => '150 Basic',
                'kapasitas_pcs' => 33,
                'kode' => 'W708150'
            ],
            [
                'daftarproses' => 'Winding 7',
                'size' => '4"',
                'class' => '150 Basic',
                'kapasitas_pcs' => 30,
                'kode' => 'W709150'
            ],
            [
                'daftarproses' => 'Winding 7',
                'size' => '5"',
                'class' => '150 Basic',
                'kapasitas_pcs' => 39,
                'kode' => 'W710150'
            ],
            [
                'daftarproses' => 'Winding 7',
                'size' => '6"',
                'class' => '150 Basic',
                'kapasitas_pcs' => 38,
                'kode' => 'W711150'
            ],
            [
                'daftarproses' => 'Winding 7',
                'size' => '8"',
                'class' => '150 Basic',
                'kapasitas_pcs' => 35,
                'kode' => 'W712150'
            ],
            [
                'daftarproses' => 'Winding 7',
                'size' => '10"',
                'class' => '150 Basic',
                'kapasitas_pcs' => 82,
                'kode' => 'W713150'
            ],
            [
                'daftarproses' => 'Winding 7',
                'size' => '1/2"',
                'class' => '300 Basic',
                'kapasitas_pcs' => 30,
                'kode' => 'W701300'
            ],
            [
                'daftarproses' => 'Winding 7',
                'size' => '3/4"',
                'class' => '300 Basic',
                'kapasitas_pcs' => 41,
                'kode' => 'W702300'
            ],
            [
                'daftarproses' => 'Winding 7',
                'size' => '1"',
                'class' => '300 Basic',
                'kapasitas_pcs' => 39,
                'kode' => 'W703300'
            ],
            [
                'daftarproses' => 'Winding 7',
                'size' => '1 1/4"',
                'class' => '300 Basic',
                'kapasitas_pcs' => 32,
                'kode' => 'W704300'
            ],
            [
                'daftarproses' => 'Winding 7',
                'size' => '1 1/2"',
                'class' => '300 Basic',
                'kapasitas_pcs' => 30,
                'kode' => 'W705300'
            ],
            [
                'daftarproses' => 'Winding 7',
                'size' => '2"',
                'class' => '300 Basic',
                'kapasitas_pcs' => 29,
                'kode' => 'W706300'
            ],
            [
                'daftarproses' => 'Winding 7',
                'size' => '2 1/2"',
                'class' => '300 Basic',
                'kapasitas_pcs' => 30,
                'kode' => 'W707300'
            ],
            
            [
                'daftarproses' => 'Winding 7',
                'size' => '3"',
                'class' => '300 Basic',
                'kapasitas_pcs' => 33,
                'kode' => 'W708300'
            ],
            [
                'daftarproses' => 'Winding 7',
                'size' => '4"',
                'class' => '300 Basic',
                'kapasitas_pcs' => 30,
                'kode' => 'W709300'
            ],
            [
                'daftarproses' => 'Winding 7',
                'size' => '5"',
                'class' => '300 Basic',
                'kapasitas_pcs' => 39,
                'kode' => 'W710300'
            ],
            [
                'daftarproses' => 'Winding 7',
                'size' => '6"',
                'class' => '300 Basic',
                'kapasitas_pcs' => 38,
                'kode' => 'W711300'
            ],
            [
                'daftarproses' => 'Winding 7',
                'size' => '8"',
                'class' => '300 Basic',
                'kapasitas_pcs' => 35,
                'kode' => 'W712300'
            ],
            [
                'daftarproses' => 'Winding 7',
                'size' => '10"',
                'class' => '300 Basic',
                'kapasitas_pcs' => 82,
                'kode' => 'W713300'
            ],
        ];

        DB::table('cycletime_produk')->insert($data);
    }
}
