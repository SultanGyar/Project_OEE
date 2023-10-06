<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KelompokSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            'Ring 1',
            'Ring 2',
            'Ring 3',
            'Sealing Element',
            'DJG'
        ];

        foreach($data as $item) {
            DB::table('kelompok')->insert([
                'daftarkelompok' => $item,
            ]);
        }
    }
}
