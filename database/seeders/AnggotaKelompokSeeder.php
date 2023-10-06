<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AnggotaKelompokSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            // Kolom 'nama_proses' dan 'kelompok' sesuai dengan struktur tabel Anda
            ['daftarproses' => 'Cutting DJG', 'daftarkelompok' => 'DJG'],
            ['daftarproses' => 'Cutting Gasket', 'daftarkelompok' => 'DJG'],
            ['daftarproses' => 'Cutting Laser', 'daftarkelompok' => 'DJG'],
            ['daftarproses' => 'Mould DJG', 'daftarkelompok' => 'DJG'],
            ['daftarproses' => 'Mould Strip V', 'daftarkelompok' => 'DJG'],
            ['daftarproses' => 'Welding DJG', 'daftarkelompok' => 'DJG'],
            ['daftarproses' => 'Deburing', 'daftarkelompok' => 'Ring 1'],
            ['daftarproses' => 'Power Press 150 Ton', 'daftarkelompok' => 'Ring 1'],
            ['daftarproses' => 'Power Press 250 Ton', 'daftarkelompok' => 'Ring 1'],
            ['daftarproses' => 'Power Press 75 Ton', 'daftarkelompok' => 'Ring 1'],
            ['daftarproses' => 'Shearing 1', 'daftarkelompok' => 'Ring 1'],
            ['daftarproses' => 'Surface Grinding', 'daftarkelompok' => 'Ring 1'],
            ['daftarproses' => 'Bubut 1', 'daftarkelompok' => 'Ring 2'],
            ['daftarproses' => 'Bubut 10', 'daftarkelompok' => 'Ring 2'],
            ['daftarproses' => 'Bubut 11', 'daftarkelompok' => 'Ring 2'],
            ['daftarproses' => 'Bubut 2', 'daftarkelompok' => 'Ring 2'],
            ['daftarproses' => 'Bubut 3', 'daftarkelompok' => 'Ring 2'],
            ['daftarproses' => 'Bubut 4', 'daftarkelompok' => 'Ring 2'],
            ['daftarproses' => 'Bubut 6', 'daftarkelompok' => 'Ring 2'],
            ['daftarproses' => 'Bubut CNC', 'daftarkelompok' => 'Ring 2'],
            ['daftarproses' => 'Turet 4', 'daftarkelompok' => 'Ring 2'],
            ['daftarproses' => 'Turet 5', 'daftarkelompok' => 'Ring 2'],
            ['daftarproses' => 'Angeling', 'daftarkelompok' => 'Ring 3'],
            ['daftarproses' => 'Auto Bending', 'daftarkelompok' => 'Ring 3'],
            ['daftarproses' => 'Bending Horizontal', 'daftarkelompok' => 'Ring 3'],
            ['daftarproses' => 'Bending Vertical', 'daftarkelompok' => 'Ring 3'],
            ['daftarproses' => 'Bubut 5', 'daftarkelompok' => 'Ring 3'],
            ['daftarproses' => 'Grouving 1', 'daftarkelompok' => 'Ring 3'],
            ['daftarproses' => 'Grouving 2', 'daftarkelompok' => 'Ring 3'],
            ['daftarproses' => 'Grouving 3', 'daftarkelompok' => 'Ring 3'],
            ['daftarproses' => 'Kamprofile', 'daftarkelompok' => 'Ring 3'],
            ['daftarproses' => 'MC Las Miller', 'daftarkelompok' => 'Ring 3'],
            ['daftarproses' => 'Plasma CNC', 'daftarkelompok' => 'Ring 3'],
            ['daftarproses' => 'Poles Ring 1', 'daftarkelompok' => 'Ring 3'],
            ['daftarproses' => 'Poles Ring 2', 'daftarkelompok' => 'Ring 3'],
            ['daftarproses' => 'Shearing 2', 'daftarkelompok' => 'Ring 3'],
            ['daftarproses' => 'Stratening', 'daftarkelompok' => 'Ring 3'],
            ['daftarproses' => 'Bubut 5', 'daftarkelompok' => 'Sealing Element'],
            ['daftarproses' => 'Laser Marking', 'daftarkelompok' => 'Sealing Element'],
            ['daftarproses' => 'Preshaping', 'daftarkelompok' => 'Sealing Element'],
            ['daftarproses' => 'Roll SWG', 'daftarkelompok' => 'Sealing Element'],
            ['daftarproses' => 'Winding 1', 'daftarkelompok' => 'Sealing Element'],
            ['daftarproses' => 'Winding 10', 'daftarkelompok' => 'Sealing Element'],
            ['daftarproses' => 'Winding 12', 'daftarkelompok' => 'Sealing Element'],
            ['daftarproses' => 'Winding 13', 'daftarkelompok' => 'Sealing Element'],
            ['daftarproses' => 'Winding 3', 'daftarkelompok' => 'Sealing Element'],
            ['daftarproses' => 'Winding 4', 'daftarkelompok' => 'Sealing Element'],
            ['daftarproses' => 'Winding 5', 'daftarkelompok' => 'Sealing Element'],
            ['daftarproses' => 'Winding 6', 'daftarkelompok' => 'Sealing Element'],
            ['daftarproses' => 'Winding 7', 'daftarkelompok' => 'Sealing Element'],
            ['daftarproses' => 'Winding 9', 'daftarkelompok' => 'Sealing Element'],
        ];

        // Menggunakan metode insert untuk mengisi data ke dalam tabel kelompok
        DB::table('anggota_kelompok')->insert($data);
    }
}
