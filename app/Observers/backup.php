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
    $proses = $produksi->proses;
    $quantity = $produksi->quantity;
    $finish_good = $produksi->finish_good;
    $reject = $produksi->reject;
    $tanggal = $produksi->tanggal;
    
    // Ambil nilai bulan dan tahun dari tanggal
    $bulan = Carbon::parse($tanggal)->format('m');
    $tahun = Carbon::parse($tanggal)->format('Y');
    
    // Cek apakah entri dengan proses yang sama, bulan yang sama, dan tahun yang sama sudah ada di tabel DataProduksi
    $dataProduksi = DataProduksi::where('proses', $proses)
        ->whereMonth('tanggal', $bulan)
        ->whereYear('tanggal', $tahun)
        ->first();
    
    if ($dataProduksi) {
        // Jika entri dengan proses yang sama, bulan yang sama, dan tahun yang sama sudah ada, tambahkan nilai baru ke entri tersebut
        $dataProduksi->quantity += $quantity;
        $dataProduksi->finish_good += $finish_good;
        $dataProduksi->reject += $reject;
        $dataProduksi->save();
    } else {
        // Jika entri dengan proses yang sama, bulan yang sama, dan tahun yang sama belum ada
        // Cek apakah ada entri dengan proses yang sama di bulan yang berbeda
        $existingDataProduksi = DataProduksi::where('proses', $proses)
            ->whereYear('tanggal', $tahun)
            ->first();
        
        if ($existingDataProduksi) {
            // Jika ada entri dengan proses yang sama di bulan yang berbeda, buat entri baru dengan bulan yang berbeda
            $newDataProduksi = new DataProduksi();
            $newDataProduksi->proses = $proses;
            $newDataProduksi->quantity = $quantity;
            $newDataProduksi->finish_good = $finish_good;
            $newDataProduksi->reject = $reject;
            $newDataProduksi->tanggal = $tanggal;
            $newDataProduksi->save();
        } else {
            // Jika tidak ada entri dengan proses yang sama di bulan yang berbeda, buat entri baru dengan bulan yang sama
            DataProduksi::create([
                'proses' => $proses,
                'quantity' => $quantity,
                'finish_good' => $finish_good,
                'reject' => $reject,
                'tanggal' => $tanggal,
            ]);
        }
    }
}





    /**
     * Handle the Produksi "updated" event.
     */
    public function updated(Produksi $produksi): void
    {
        //
    }

    /**
     * Handle the Produksi "deleted" event.
     */
    public function deleted(Produksi $produksi): void
    {
        // Kurangi nilai quantity di tabel DataProduksi berdasarkan proses yang sama
        $dataProduksi = DataProduksi::where('proses', $produksi->proses)->first();
        
        if ($dataProduksi) {
            $dataProduksi->decrement('quantity', $produksi->quantity);
            
            // Cek apakah nilai quantity setelah dikurangi menjadi 0 atau minus
            if ($dataProduksi->quantity <= 0) {
                $dataProduksi->delete();
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
