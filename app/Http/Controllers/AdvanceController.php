<?php

namespace App\Http\Controllers;

use App\Models\DataProduksi;
use Illuminate\Http\Request;

class AdvanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $getData = $this->getProsesData();
        return view('advance', [
            'getData' => $getData
        ]);
    }

    public function getProsesData($format = 'array')
    {
        $currentMonth = date('m');
        $currentYear = date('Y');
    
        $data = DataProduksi::whereYear('tanggal', $currentYear)
            ->whereMonth('tanggal', $currentMonth)
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
