<?php

namespace App\Imports;

use App\Models\Produksi;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProduksiImport implements ToModel, WithHeadingRow, WithCalculatedFormulas
{

    public function decimalToTime($decimalValue)
    {
        $totalSeconds = (int) round($decimalValue * 86400); // 86400 detik dalam satu hari
        $hours = (int) ($totalSeconds / 3600);
        $minutes = (int) (($totalSeconds % 3600) / 60);
        $seconds = $totalSeconds % 60;

        return sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
    }

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Produksi([
            'nama_user' => $row['operator'],
            'tanggal' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['tanggal']),
            'daftarproses' => $row['proses'],
            'daftarkelompok' => $row['kelompok'],
            'produk_size' => $row['size'],
            'produk_class' => $row['class'],
            'kapasitas_pcs' => $row['kapasitas_pcs'],
            'target_quantity' => $row['target_quantity'],
            'kode' => $row['kode'],
            'quantity' => $row['actual_quantity'],
            'finish_good' => $row['good_quantity'],
            'reject' => $row['not_good'],
            'daftarketerangan' => $row['keterangan'],
            'operating_start_time' => $this->decimalToTime($row['operating_start_time']),
            'operating_end_time' => $this->decimalToTime($row['operating_end_time']),
            'operating_time' => $this->decimalToTime($row['operating_time']),
            'down_time' => $row['down_time'],
            'actual_time' => $this->decimalToTime($row['actual_time']),
            'a_time' => $row['a_time'],
            'b_time' => $row['b_time'],
            'c_time' => $row['c_time'],
            'd_time' => $row['d_time'],
            'e_time' => $row['e_time'],
            'f_time' => $row['f_time'],
            'g_time' => $row['g_time'],
            'h_time' => $row['h_time']
        ]);
    }

    
}
