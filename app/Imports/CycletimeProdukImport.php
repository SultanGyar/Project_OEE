<?php

namespace App\Imports;

use App\Models\CycletimeProduk;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CycletimeProdukImport implements ToModel, WithHeadingRow, WithCalculatedFormulas
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new CycletimeProduk([
            'daftarproses' => $row['proses'],
            'size' => $row['size'],
            'class' => $row['class'],
            'kapasitas_pcs' => $row['cycle_time_detik'],
            'kode' => $row['kode']
        ]);
    }
}
