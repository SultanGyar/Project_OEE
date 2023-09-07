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
            'BLANKING 1',
            'BLANKING 2',
            'BLANKING 3',
            'SHEARING 01',
            'DEBURING',
            'BUBUT 1',
            'BUBUT 2',
            'BUBUT 3',
            'BUBUT 4',
            'BUBUT 5',
            'BUBUT 6',
            'BUBUT 7',
            'BUBUT 8',
            'BUBUT CNC',
            'BUBUT 10',
            'BUBUT 11',
            'TURET 4',
            'TURET 5',
            'CHAMPER',
            'ROLLING BENDING 1 (Vertical)',
            'FLATTENING',
            'WELDING TIG 2',
            'GRINDING WELDING',
            'GRINDING',
            'GROVE 1',
            'GROVE 2',
            'GROVE 3',
            'ANGLING IR MACHINE',
            'CNC LASER CUTTING',
            'SHEARING 02',
            'TURNING 5',
            'PLASMA CNC',
            'AUTOMATIC BEND',
            'POLISHING RING MACHINE',
            'BUBUT SOLID SERATED',
            'WINDING 1',
            'POWDER COATING',
            'WINDING 3',
            'WINDING 4',
            'WINDING 5',
            'WINDING 6',
            'WINDING 7',
            'WINDING 9',
            'WINDING 10',
            'WINDING 11',
            'WINDING 12',
            'WINDING 13',
            'MARKING LASER',
            'ROLLING SWG',
            'PACKAGING',
            'ASSEMBLING',
        ];
        
        usort($data, function ($a, $b) {
            return strnatcmp($a, $b);       
        });
        
        foreach ($data as $item) {
            DB::table('proses')->insert([
                'daftarproses' => $item,
            ]);
        }
    }
}