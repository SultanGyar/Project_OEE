<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KeteranganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            'Dimensi',
            'Ring Melengkung',
            'Permukaan Cacat',
            'Plating',
            'Parit Miring',
            'Salah Marking',
        ];
        
        asort($data);
        foreach ($data as $item) {
            DB::table('keterangan')->insert([
                'daftarketerangan' => $item,
            ]);
        }
    }
}
