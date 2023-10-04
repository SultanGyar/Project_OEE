<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KelompokSeeder extends Seeder
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
            ['proses_kelompok' => 'Cutting DJG', 'nama_kelompok' => 'DJG'],
            ['proses_kelompok' => 'Cutting Gasket', 'nama_kelompok' => 'DJG'],
            ['proses_kelompok' => 'Cutting Laser', 'nama_kelompok' => 'DJG'],
            ['proses_kelompok' => 'Mould DJG', 'nama_kelompok' => 'DJG'],
            ['proses_kelompok' => 'Mould Strip V', 'nama_kelompok' => 'DJG'],
            ['proses_kelompok' => 'Welding DJG', 'nama_kelompok' => 'DJG'],
            ['proses_kelompok' => 'Deburing', 'nama_kelompok' => 'Ring 1'],
            ['proses_kelompok' => 'Power Press 150 Ton', 'nama_kelompok' => 'Ring 1'],
            ['proses_kelompok' => 'Power Press 250 Ton', 'nama_kelompok' => 'Ring 1'],
            ['proses_kelompok' => 'Power Press 75 Ton', 'nama_kelompok' => 'Ring 1'],
            ['proses_kelompok' => 'Shearing 1', 'nama_kelompok' => 'Ring 1'],
            ['proses_kelompok' => 'Surface Grinding', 'nama_kelompok' => 'Ring 1'],
            ['proses_kelompok' => 'Bubut 1', 'nama_kelompok' => 'Ring 2'],
            ['proses_kelompok' => 'Bubut 10', 'nama_kelompok' => 'Ring 2'],
            ['proses_kelompok' => 'Bubut 11', 'nama_kelompok' => 'Ring 2'],
            ['proses_kelompok' => 'Bubut 2', 'nama_kelompok' => 'Ring 2'],
            ['proses_kelompok' => 'Bubut 3', 'nama_kelompok' => 'Ring 2'],
            ['proses_kelompok' => 'Bubut 4', 'nama_kelompok' => 'Ring 2'],
            ['proses_kelompok' => 'Bubut 6', 'nama_kelompok' => 'Ring 2'],
            ['proses_kelompok' => 'Bubut CNC', 'nama_kelompok' => 'Ring 2'],
            ['proses_kelompok' => 'Turet 4', 'nama_kelompok' => 'Ring 2'],
            ['proses_kelompok' => 'Turet 5', 'nama_kelompok' => 'Ring 2'],
            ['proses_kelompok' => 'Angeling', 'nama_kelompok' => 'Ring 3'],
            ['proses_kelompok' => 'Auto Bending', 'nama_kelompok' => 'Ring 3'],
            ['proses_kelompok' => 'Bending Horizontal', 'nama_kelompok' => 'Ring 3'],
            ['proses_kelompok' => 'Bending Vertical', 'nama_kelompok' => 'Ring 3'],
            ['proses_kelompok' => 'Bubut 5', 'nama_kelompok' => 'Ring 3'],
            ['proses_kelompok' => 'Grouving 1', 'nama_kelompok' => 'Ring 3'],
            ['proses_kelompok' => 'Grouving 2', 'nama_kelompok' => 'Ring 3'],
            ['proses_kelompok' => 'Grouving 3', 'nama_kelompok' => 'Ring 3'],
            ['proses_kelompok' => 'Kamprofile', 'nama_kelompok' => 'Ring 3'],
            ['proses_kelompok' => 'MC Las Miller', 'nama_kelompok' => 'Ring 3'],
            ['proses_kelompok' => 'Plasma CNC', 'nama_kelompok' => 'Ring 3'],
            ['proses_kelompok' => 'Poles Ring 1', 'nama_kelompok' => 'Ring 3'],
            ['proses_kelompok' => 'Poles Ring 2', 'nama_kelompok' => 'Ring 3'],
            ['proses_kelompok' => 'Shearing 2', 'nama_kelompok' => 'Ring 3'],
            ['proses_kelompok' => 'Stratening', 'nama_kelompok' => 'Ring 3'],
            ['proses_kelompok' => 'Bubut 5', 'nama_kelompok' => 'Sealing Element'],
            ['proses_kelompok' => 'Laser Marking', 'nama_kelompok' => 'Sealing Element'],
            ['proses_kelompok' => 'Preshaping', 'nama_kelompok' => 'Sealing Element'],
            ['proses_kelompok' => 'Roll SWG', 'nama_kelompok' => 'Sealing Element'],
            ['proses_kelompok' => 'Winding 1', 'nama_kelompok' => 'Sealing Element'],
            ['proses_kelompok' => 'Winding 10', 'nama_kelompok' => 'Sealing Element'],
            ['proses_kelompok' => 'Winding 12', 'nama_kelompok' => 'Sealing Element'],
            ['proses_kelompok' => 'Winding 13', 'nama_kelompok' => 'Sealing Element'],
            ['proses_kelompok' => 'Winding 3', 'nama_kelompok' => 'Sealing Element'],
            ['proses_kelompok' => 'Winding 4', 'nama_kelompok' => 'Sealing Element'],
            ['proses_kelompok' => 'Winding 5', 'nama_kelompok' => 'Sealing Element'],
            ['proses_kelompok' => 'Winding 6', 'nama_kelompok' => 'Sealing Element'],
            ['proses_kelompok' => 'Winding 7', 'nama_kelompok' => 'Sealing Element'],
            ['proses_kelompok' => 'Winding 9', 'nama_kelompok' => 'Sealing Element'],
        ];

        // Menggunakan metode insert untuk mengisi data ke dalam tabel kelompok
        DB::table('kelompok')->insert($data);
    }
}
