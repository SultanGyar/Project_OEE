<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProsesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            'Power Press 75 Ton',
            'Power Press 150 Ton',
            'Power Press 250 Ton',
            'Shearing 1',
            'Deburing',
            'Surface Grinding',
            'Bubut 1',
            'Bubut 2',
            'Bubut 3',
            'Bubut 4',
            'Bubut 6',
            'Bubut CNC',
            'Bubut 10',
            'Bubut 11',
            'Turet 4',
            'Turet 5',
            'Cutting Laser',
            'Mould DJG',
            'Mould Strip V',
            'Welding DJG',
            'Cutting Gasket',
            'Cutting DJG',
            'Shearing 2',
            'Stratening',
            'Auto Bending',
            'Bending Vertical',
            'Bending Horizontal',
            'Grouving 1',
            'Grouving 2',
            'Grouving 3',
            'Kamprofile',
            'Bubut 5',
            'Angeling',
            'Poles Ring 1',
            'Poles Ring 2',
            'Plasma CNC',
            'MC Las Miller',
            'Winding 1',
            'Winding 3',
            'Winding 4',
            'Winding 5',
            'Winding 6',
            'Winding 7',
            'Winding 9',
            'Winding 10',
            'Winding 12',
            'Winding 13',
            'Laser Marking',
            'Roll SWG',
            'Preshaping'
        ];
        
        natsort($data);

        foreach ($data as $item) {
            DB::table('proses')->insert([
                'daftarproses' => $item,
            ]);
        }
    }
}