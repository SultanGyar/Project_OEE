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
    public function index()
    {
        return view('home');
    }

    public function getProsesData()
    {
        $prosesValues = DataProduksi::select('proses')->distinct()->get();
        return response()->json($prosesValues);
    }

    public function filterChartData(Request $request)
    {
        $proses = $request->input('proses');
        $bulan = $request->input('bulan');

        // Lakukan pengambilan data sesuai filter yang dipilih
        $data = DataProduksi::where('proses', $proses)
            ->whereMonth('tanggal', date('m', strtotime($bulan)))
            ->first();

        if ($data) {
            $performanceData = [
                'target_quantity' => $data->target_quantity,
                'quantity' => $data->quantity
            ];

            $availabilityData = [
                'operating_time' => $data->operating_time,
                'actual_time' => $data->actual_time,
                'down_time' => $data->down_time,
            ];

            $qualityData = [
                'quantity' => $data->quantity,
                'finish_good' => $data->finish_good,
                'reject' => $data->reject,
            ];

            $updateData = [
                'performance' => $performanceData,
                'availability' => $availabilityData,
                'quality' => $qualityData
            ];
            return response()->json($updateData);
        }
        return response()->json(['error' => 'No data available']);
    }
}
