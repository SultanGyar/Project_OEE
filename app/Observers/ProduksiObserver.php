<?php

namespace App\Observers;

use App\Models\Produksi;
use App\Models\DataProduksi;
use Carbon\Carbon;

class ProduksiObserver
{
    /**
     * Handle the Produksi "created" event.
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

    // Metode untuk melakukan penambahan waktu pada kolom waktu yang telah disediakan sebelumnya
    private function addTimes($time1, $time2)
    {
        // Konversi waktu menjadi menit sebelum dilakukan perhitungan
        $time1 = $this->convertToMinutes($time1);
        $time2 = $this->convertToMinutes($time2);

        // Hitung total waktu dalam menit
        $totalMinutes = $time1 + $time2;

        // Ubah total waktu dalam menit menjadi format 'HH:mm:ss'
        return $this->formatDuration($totalMinutes);
    }

    // Metode untuk mengonversi waktu dalam format 'HH:mm:ss' menjadi menit
    private function convertToMinutes($time)
    {
        list($hours, $minutes) = explode(':', $time);
        return $hours * 60 + $minutes;
    }

    // Metode untuk mengonversi total waktu dalam menit menjadi format 'HH:mm:ss'
    private function formatDuration($totalMinutes)
    {
        $hours = floor($totalMinutes / 60);
        $minutes = $totalMinutes % 60;

        // Format ke format 'HH:mm:ss'
        return sprintf('%02d:%02d:%02d', $hours, $minutes, 0); // Set detik ke 0.
    }

    /**
     * Handle the Produksi "deleted" event.
     */
    public function deleted(Produksi $produksi): void
    {
        // Kurangi nilai quantity di tabel DataProduksi berdasarkan proses yang sama
        $data_produksi = DataProduksi::where('proses', $produksi->daftarproses)->first();

        if ($data_produksi) {
            $data_produksi->decrement('target_quantity', $produksi->target_quantity);
            $data_produksi->decrement('quantity', $produksi->quantity);
            $data_produksi->decrement('finish_good', $produksi->finish_good);
            $data_produksi->decrement('reject', $produksi->reject);
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

    // Metode untuk melakukan pengurangan waktu pada kolom waktu yang telah disediakan sebelumnya
    private function subtractTimes($time1, $time2)
    {
        // Konversi waktu menjadi menit sebelum dilakukan perhitungan
        $time1 = $this->convertToMinutes($time1);
        $time2 = $this->convertToMinutes($time2);

        // Hitung total waktu dalam menit
        $totalMinutes = $time1 - $time2;

        // Ubah total waktu dalam menit menjadi format 'HH:mm:ss'
        return $this->formatDuration($totalMinutes);
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

    /**
     * Handle the Produksi "updated" event.
     */
    public function updated(Produksi $produksi): void
    {
        // Cek apakah kolom-kolom tertentu dalam model Produksi telah diubah
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
            // Ambil nilai kolom-kolom yang diubah
            $updatedProses = $produksi->daftarproses;
            $updatedKelompok = $produksi->daftarkelompok;
            $updatedTargetQuantity = $produksi->target_quantity;
            $updatedQuantity = $produksi->quantity;
            $updatedFinishGood = $produksi->finish_good;
            $updatedReject = $produksi->reject;
            $updatedOperatingTime = $produksi->operating_time;
            $updatedActualTime = $produksi->actual_time;
            $updatedDownTime = $produksi->down_time;
            $updatedTanggal = $produksi->tanggal;


            $bulan = Carbon::parse($updatedTanggal)->format('m');
            $tahun = Carbon::parse($updatedTanggal)->format('Y');
            // Cari entri DataProduksi yang sesuai
            $dataProduksi = DataProduksi::where('proses', $produksi->daftarproses)
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->first();

            if ($dataProduksi) {
                // Perbarui nilai-nilai sesuai dengan perubahan pada Produksi
                $dataProduksi->proses = $updatedProses;
                $dataProduksi->kelompokan = $updatedKelompok;
                $dataProduksi->target_quantity = $updatedTargetQuantity;
                $dataProduksi->quantity = $updatedQuantity;
                $dataProduksi->finish_good = $updatedFinishGood;
                $dataProduksi->reject = $updatedReject;
                $dataProduksi->operating_time = $updatedOperatingTime;
                $dataProduksi->actual_time = $updatedActualTime;
                $dataProduksi->down_time = $updatedDownTime;
                $dataProduksi->tanggal = $updatedTanggal;
                $dataProduksi->save();
            }
        }
    }
}
