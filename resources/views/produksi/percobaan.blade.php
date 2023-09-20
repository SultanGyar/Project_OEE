<?php

namespace App\Http\Controllers;

use App\Models\DataProduksi;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $chartData = $this->getDataForChart(new Request());
        return view('home', compact('chartData')); // Pass 'chartData' to the view
    }

    public function getDataForChart(Request $request)
    {
        $selectedMonth = $request->input('filterMonth', date('Y-m'));
        $dataProduksi = DataProduksi::whereMonth('tanggal', '=', date('m', strtotime($selectedMonth)))
            ->whereYear('tanggal', '=', date('Y', strtotime($selectedMonth)))
            ->get();

        $groupedData = [];

        foreach ($dataProduksi as $item) {
            $proses = $item->proses;
            $kataKunci = preg_split('/\s+/', $proses);
            $kunci = $kataKunci[0];

            if (!isset($groupedData[$kunci])) {
                $groupedData[$kunci] = [
                    'performance' => [
                        'target_quantity' => 0,
                        'quantity' => 0,
                    ],
                    'availability' => [
                        'operating_time' => '00:00:00',
                        'actual_time' => '00:00:00',
                        'down_time' => '00:00:00',
                    ],
                    'quality' => [
                        'quantity' => 0,
                        'finish_good' => 0,
                        'reject' => 0,
                    ],
                ];
            }

            $groupedData[$kunci]['performance']['target_quantity'] += $item->target_quantity;
            $groupedData[$kunci]['performance']['quantity'] += $item->quantity;
            $groupedData[$kunci]['availability']['operating_time'] = $this->addTime(
                $groupedData[$kunci]['availability']['operating_time'],
                $item->operating_time
            );
            $groupedData[$kunci]['availability']['actual_time'] = $this->addTime(
                $groupedData[$kunci]['availability']['actual_time'],
                $item->actual_time
            );

            if ($item->down_time) {
                $groupedData[$kunci]['availability']['down_time'] = $this->addTime(
                    $groupedData[$kunci]['availability']['down_time'],
                    $item->down_time
                );
            }

            $groupedData[$kunci]['quality']['quantity'] += $item->quantity;
            $groupedData[$kunci]['quality']['finish_good'] += $item->finish_good;
            $groupedData[$kunci]['quality']['reject'] += $item->reject;
        }

        return response()->json($groupedData);
    }

    private function addTime($time1, $time2)
    {
        $time1Parts = explode(':', $time1);
        $time2Parts = explode(':', $time2);

        $hours = (int) $time1Parts[0] + (int) $time2Parts[0];
        $minutes = (int) $time1Parts[1] + (int) $time2Parts[1];
        $seconds = (int) $time1Parts[2] + (int) $time2Parts[2];

        $minutes += floor($seconds / 60);
        $seconds %= 60;
        $hours += floor($minutes / 60);
        $minutes %= 60;

        return sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
    }
}
