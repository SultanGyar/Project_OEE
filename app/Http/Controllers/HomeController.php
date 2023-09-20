<?php

namespace App\Http\Controllers;

use App\Models\DataProduksi;
use Illuminate\Http\Request;

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

        $data = DataProduksi::whereYear('tanggal', substr($selectedMonth, 0, 4))
            ->whereMonth('tanggal', substr($selectedMonth, 5, 2))
            ->get();

        if ($data->isEmpty()) {
            if ($format === 'json') {
                return response()->json(['error' => 'No data available']);
            } else {
                return []; // Return an empty array when no data is available
            }
        }

        $responseData = [];

        foreach ($data as $entry) {
            $responseData[] = [
                'id' => $entry->id,
                'proses' => $entry->proses,
                'target_quantity' => $entry->target_quantity,
                'operating_time' => $entry->operating_time,
                'actual_time' => $entry->actual_time,
                'down_time' => $entry->down_time,
                'quantity' => $entry->quantity,
                'finish_good' => $entry->finish_good,
                'reject' => $entry->reject,
            ];
        }

        if ($format === 'json') {
            return response()->json($responseData);
        } else {
            return $responseData;
        }
    }
    
}
