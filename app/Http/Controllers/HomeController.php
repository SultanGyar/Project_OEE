<?php

namespace App\Http\Controllers;

use App\Models\DataProduksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $selectedMonth = $request->input('filterMonth'); // Ambil bulan yang dipilih dari form
    
        // Dapatkan data produksi
        $getData = $this->getProsesData('array', $selectedMonth);
    
        return view('home', [
            'getData' => $getData,
            'selectedMonth' => $selectedMonth, // Kirim bulan yang dipilih ke tampilan
        ]);
    }
    
    public function getProsesData($format = 'array', $selectedMonth = null)
    {
        // Menggunakan bulan yang dipilih jika disediakan, jika tidak, menggunakan bulan dan tahun saat ini
        if (!$selectedMonth) {
            $selectedMonth = date('Y-m');
        }
    
        // Mengambil data dari tabel DataProduksi berdasarkan bulan yang dipilih
        $data = DataProduksi::whereYear('tanggal', substr($selectedMonth, 0, 4))
            ->whereMonth('tanggal', substr($selectedMonth, 5, 2))
            ->get();
    
        // Inisialisasi data kelompok dari tabel kelompok (gantilah dengan nama tabel yang sesuai)
        $defaultKelompok = DB::table('kelompok')->get();
    
        $groupedData = [];
    
        // Inisialisasi semua kelompok dengan data default
        foreach ($defaultKelompok as $default) {
            $kelompokan = $default->daftarkelompok;
    
            $groupedData[$kelompokan] = [
                'target_quantity' => 0,
                'operating_time' => '00:00:00',
                'actual_time' => '00:00:00',
                'down_time' => '00:00:00',
                'quantity' => 0,
                'finish_good' => 0,
                'reject' => 0,
            ];
        }
    
        // Jika ada data produksi, perbarui nilai kelompok yang sesuai
        foreach ($data as $entry) {
            $kelompokan = $entry->kelompokan;
    
            // Jumlahkan data produksi ke dalam kelompok yang sesuai
            $groupedData[$kelompokan]['target_quantity'] += $entry->target_quantity;
            $groupedData[$kelompokan]['operating_time'] = $this->addTime(
                $groupedData[$kelompokan]['operating_time'],
                $entry->operating_time
            );
            $groupedData[$kelompokan]['actual_time'] = $this->addTime(
                $groupedData[$kelompokan]['actual_time'],
                $entry->actual_time
            );
            $groupedData[$kelompokan]['down_time'] = $this->addTime(
                $groupedData[$kelompokan]['down_time'],
                $entry->down_time
            );
            $groupedData[$kelompokan]['quantity'] += $entry->quantity;
            $groupedData[$kelompokan]['finish_good'] += $entry->finish_good;
            $groupedData[$kelompokan]['reject'] += $entry->reject;
        }
    
        if ($format === 'json') {
            return response()->json($groupedData);
        } else {
            return $groupedData;
        }
    }
    
    
    
    private function addTime($time1, $time2)
    {
        $time1Parts = explode(':', $time1);
        $time2Parts = explode(':', $time2);
    
        $hours = (int)$time1Parts[0] + (int)$time2Parts[0];
        $minutes = (int)$time1Parts[1] + (int)$time2Parts[1];
        $seconds = (int)$time1Parts[2] + (int)$time2Parts[2];
    
        // Handle carryovers
        $minutes += floor($seconds / 60);
        $seconds %= 60;
        $hours += floor($minutes / 60);
        $minutes %= 60;
    
        return sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
    }
    
    
}
