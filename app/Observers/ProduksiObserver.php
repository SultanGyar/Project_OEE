<?php

namespace App\Observers;

use App\Models\DataProduksi;
use App\Models\Produksi;
use Carbon\Carbon;

class ProduksiObserver
{
     /**
     * Handle the Produksi "created" event.
     *
     * @param  \App\Models\Produksi  $produksi
     * @return void
     */
    public function created(Produksi $produksi): void
    {
        // Ambil nilai proses, quantity, finish_good, reject, dan tanggal dari entri Produksi yang baru dibuat
        $dataproses = $produksi->daftarproses;
        $datakelompok = $produksi->daftarkelompok;
        $target_quantity = $produksi->target_quantity;
        $quantity = $produksi->quantity;
        $finish_good = $produksi->finish_good;
        $reject = $produksi->reject;
        $operating_time = $produksi->operating_time;
        $actual_time = $produksi->actual_time;
        $down_time = $produksi->down_time;
        $tanggal = $produksi->tanggal;

        // Ambil nilai bulan dan tahun dari tanggal
        $bulan = Carbon::parse($tanggal)->format('m');
        $tahun = Carbon::parse($tanggal)->format('Y');

        // Cek apakah entri dengan proses yang sama, bulan yang sama, dan tahun yang sama sudah ada di tabel DataProduksi
        $data_produksi = DataProduksi::where('proses', $dataproses)
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->first();

        if ($data_produksi) {
            // Jika entri dengan proses yang sama, bulan yang sama, dan tahun yang sama sudah ada, tambahkan nilai baru ke entri tersebut
            $data_produksi->target_quantity += $target_quantity;
            $data_produksi->quantity += $quantity;
            $data_produksi->finish_good += $finish_good;
            $data_produksi->reject += $reject;
            $data_produksi->operating_time = $this->addTimes($data_produksi->operating_time, $operating_time);
            $data_produksi->actual_time = $this->addTimes($data_produksi->actual_time, $actual_time);
            $data_produksi->down_time = $this->addTimes($data_produksi->down_time, $down_time);
            $data_produksi->save();
        } else {
            // Jika entri dengan proses yang sama, bulan yang sama, dan tahun yang sama belum ada
            // Buat entri baru di tabel Data_produksi
            DataProduksi::create([
                'proses' => $dataproses,
                'kelompokan' => $datakelompok,
                'target_quantity' => $target_quantity,
                'quantity' => $quantity,
                'finish_good' => $finish_good,
                'reject' => $reject,
                'operating_time' => $operating_time,
                'actual_time' => $actual_time,
                'down_time' => $down_time,
                'tanggal' => $tanggal,
            ]);
        }
    }

    
    private function addTimes($time1, $time2)
    {
        // Convert time values to minutes
        $minutes1 = $this->timeToMinutes($time1);
        $minutes2 = $this->timeToMinutes($time2);
    
        // Add minutes
        $totalMinutes = $minutes1 + $minutes2;
    
        // Convert total minutes back to 'H:i:s' format
        return $this->minutesToTime($totalMinutes);
    }
    
    private function timeToMinutes($time)
    {
        $timeArray = explode(':', $time);

        $hours = isset($timeArray[0]) ? (int)$timeArray[0] : 0;
        $minutes = isset($timeArray[1]) ? (int)$timeArray[1] : 0;

        return ($hours * 60) + $minutes;
    }
    
    private function minutesToTime($minutes)
    {
        $hours = floor($minutes / 60);
        $minutes = $minutes % 60;
    
        return sprintf('%02d:%02d:00', $hours, $minutes);
    }

    /**
     * Handle the Produksi "updated" event.
     */
    public function updated(Produksi $produksi): void
{
    if ($produksi->isDirty([
        'daftarproses',
        'daftarkelompok',
        'target_quantity',
        'quantity',
        'finish_good',
        'reject',
        'operating_time',
        'actual_time',
        'down_time',
        'tanggal'
    ])) {
        // Dapatkan nilai lama dari kolom yang diubah
        $oldValues = $produksi->getOriginal();

        // Cari entri DataProduksi yang sesuai dengan data lama
        $dataProduksiLama = DataProduksi::where('proses', $oldValues['daftarproses'])
            ->whereMonth('tanggal', Carbon::parse($oldValues['tanggal'])->format('m'))
            ->whereYear('tanggal', Carbon::parse($oldValues['tanggal'])->format('Y'))
            ->first();

        // Hapus nilai lama dari DataProduksi
        if ($dataProduksiLama) {
            $dataProduksiLama->target_quantity -= $oldValues['target_quantity'];
            $dataProduksiLama->quantity -= $oldValues['quantity'];
            $dataProduksiLama->finish_good -= $oldValues['finish_good'];
            $dataProduksiLama->reject -= $oldValues['reject'];
            $dataProduksiLama->operating_time = $this->subtractTimes($dataProduksiLama->operating_time, $oldValues['operating_time']);
            $dataProduksiLama->actual_time = $this->subtractTimes($dataProduksiLama->actual_time, $oldValues['actual_time']);
            $dataProduksiLama->down_time = $this->subtractTimes($dataProduksiLama->down_time, $oldValues['down_time']);

            // Cek apakah nilai quantity setelah dikurangi menjadi 0 atau minus
            if ($dataProduksiLama->quantity <= 0) {
                $dataProduksiLama->delete();
            } else {
                $dataProduksiLama->save();
            }
        }

        // Cari entri DataProduksi yang sesuai dengan data baru
        $data_produksi = DataProduksi::where('proses', $produksi->daftarproses)
            ->whereMonth('tanggal', Carbon::parse($produksi->tanggal)->format('m'))
            ->whereYear('tanggal', Carbon::parse($produksi->tanggal)->format('Y'))
            ->first();

        if ($data_produksi) {
            // Jika entri dengan proses yang sama, bulan yang sama, dan tahun yang sama sudah ada, tambahkan nilai baru ke entri tersebut
            $data_produksi->target_quantity += $produksi->target_quantity;
            $data_produksi->quantity += $produksi->quantity;
            $data_produksi->finish_good += $produksi->finish_good;
            $data_produksi->reject += $produksi->reject;
            $data_produksi->operating_time = $this->addTimes($data_produksi->operating_time, $produksi->operating_time);
            $data_produksi->actual_time = $this->addTimes($data_produksi->actual_time, $produksi->actual_time);
            $data_produksi->down_time = $this->addTimes($data_produksi->down_time, $produksi->down_time);
            $data_produksi->save();
        } else {
            // Jika entri dengan proses yang sama, bulan yang sama, dan tahun yang sama belum ada
            // Buat entri baru di tabel Data_produksi
            DataProduksi::create([
                'proses' => $produksi->daftarproses,
                'kelompokan' => $produksi->daftarkelompok,
                'target_quantity' => $produksi->target_quantity,
                'quantity' => $produksi->quantity,
                'finish_good' => $produksi->finish_good,
                'reject' => $produksi->reject,
                'operating_time' => $produksi->operating_time,
                'actual_time' => $produksi->actual_time,
                'down_time' => $produksi->down_time,
                'tanggal' => $produksi->tanggal,
            ]);
        }
    }
}


     private function subtractTimes($time1, $time2)
    {
        // Konversi waktu menjadi menit sebelum dilakukan perhitungan
        $time1 = $this->timeToMinutes($time1);
        $time2 = $this->timeToMinutes($time2);

        // Hitung total waktu dalam menit
        $totalMinutes = $time1 - $time2;

        // Ubah total waktu dalam menit menjadi format 'HH:mm:ss'
        return $this->minutesToTime($totalMinutes);
    }

    /**
     * Handle the Produksi "deleted" event.
     */
    public function deleted(Produksi $produksi): void
    {
        // Ambil data produksi yang sesuai
        $data_produksi = DataProduksi::where('proses', $produksi->daftarproses)
            ->whereMonth('tanggal', Carbon::parse($produksi->tanggal)->format('m'))
            ->whereYear('tanggal', Carbon::parse($produksi->tanggal)->format('Y'))
            ->first();

        if ($data_produksi) {
            // Simpan data asli sebelum pengurangan
            $originalData = $data_produksi->replicate();

            // Kurangi nilai quantity di tabel DataProduksi berdasarkan proses yang sama
            $data_produksi->decrement('target_quantity', $produksi->target_quantity);
            $data_produksi->decrement('quantity', $produksi->quantity);
            $data_produksi->decrement('finish_good', $produksi->finish_good);
            $data_produksi->decrement('reject', $produksi->reject);

            // Kurangi waktu
            $data_produksi->operating_time = $this->subtractTimes($data_produksi->operating_time, $produksi->operating_time);
            $data_produksi->actual_time = $this->subtractTimes($data_produksi->actual_time, $produksi->actual_time);
            $data_produksi->down_time = $this->subtractTimes($data_produksi->down_time, $produksi->down_time);

            // Cek apakah nilai quantity setelah dikurangi menjadi 0 atau minus
            if ($data_produksi->quantity <= 0) {
                $data_produksi->delete();
            } else {
                $data_produksi->save();
            }
        }
    }


    /**
     * Handle the Produksi "restored" event.
     */
    public function restored(Produksi $produksi): void
    {
        //
    }

    /**
     * Handle the Produksi "force deleted" event.
     */
    public function forceDeleted(Produksi $produksi): void
    {
        //
    }
}
