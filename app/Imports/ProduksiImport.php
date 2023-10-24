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
            'kapasitas_pcs' => $row['kapasitas_pcs'],
            'target_quantity' => $row['target_quantity'],
            'daftarkelompok' => $row['kelompok'],
            'kode' => $row['kode'],
            'quantity' => $row['actual_quantity'],
            'finish_good' => $row['good_quantity'],
            'reject' => $row['not_good'],
            'daftarketerangan' => $row['keterangan'],
            'operating_start_time' => $this->decimalToTime($row['operating_start_time']),
            'operating_end_time' => $this->decimalToTime($row['operating_end_time']),
            'operating_time' => $this->decimalToTime($row['operating_time']),
            'down_time' => $this->decimalToTime($row['down_time']),
            'actual_time' => $this->decimalToTime($row['actual_time']),
            'a_start_time' => $this->decimalToTime($row['a_start_time']),
            'a_end_time' => $this->decimalToTime($row['a_end_time']),
            'a_time' => $this->decimalToTime($row['a_time']),
            'b_start_time' => $this->decimalToTime($row['b_start_time']),
            'b_end_time' => $this->decimalToTime($row['b_end_time']),
            'b_time' => $this->decimalToTime($row['b_time']),
            'c_start_time' => $this->decimalToTime($row['c_start_time']),
            'c_end_time' => $this->decimalToTime($row['c_end_time']),
            'c_time' => $this->decimalToTime($row['c_time']),
            'd_start_time' => $this->decimalToTime($row['d_start_time']),
            'd_end_time' => $this->decimalToTime($row['d_end_time']),
            'd_time' => $this->decimalToTime($row['d_time']),
            'e_start_time' => $this->decimalToTime($row['e_start_time']),
            'e_end_time' => $this->decimalToTime($row['e_end_time']),
            'e_time' => $this->decimalToTime($row['e_time']),
            'f_start_time' => $this->decimalToTime($row['f_start_time']),
            'f_end_time' => $this->decimalToTime($row['f_end_time']),
            'f_time' => $this->decimalToTime($row['f_time']),
            'g_start_time' => $this->decimalToTime($row['g_start_time']),
            'g_end_time' => $this->decimalToTime($row['g_end_time']),
            'g_time' => $this->decimalToTime($row['g_time']),
            'h_start_time' => $this->decimalToTime($row['h_start_time']),
            'h_end_time' => $this->decimalToTime($row['h_end_time']),
            'h_time' => $this->decimalToTime($row['h_time'])
        ]);
    }

    
}
