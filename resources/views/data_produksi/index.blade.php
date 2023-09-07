@extends('adminlte::page')
@section('title', 'Recap Produksi')
@section('content_header')
<h1 class="m-0 text-dark">Recap Produksi</h1>

@stop
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="card-header">
                    <h4 class="card-title-center text-center text-dark">Data Produksi Bulanan</h4>
                </div>
                <div class="row mb-3 mt-3">
                    <div class="col-auto">
                        <form id="filterForm" method="get" class="form-inline">
                            @php
                                $currentYear = date('Y');
                                $currentMonth = date('m');
                                $currentDate = "{$currentYear}-{$currentMonth}";
                                $selectedMonth = request('filterMonth', $currentDate); // Mengambil bulan dari permintaan atau bulan saat ini jika tidak ada permintaan
                            @endphp
                            <input type="month" class="form-control" id="filterMonth" name="filterMonth"
                                   value="{{ $selectedMonth }}" max="{{ $currentDate }}">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
                            
                <div class="table-responsive">
                    <table class="table table-hover table-bordered table-striped" id="example2">
                        <thead>
                            <tr style="text-align: center; background-color: #7895CB;">
                                <th>No.</th>
                                <th>Proses</th>
                                <th>Target Quantity</th>
                                <th>Actual Quantity</th>
                                <th>Good Quality</th>
                                <th>Not Good</th>
                                <th>Operating Time</th>
                                <th>Actual Time</th>
                                <th>Down Time</th>
                                <th>Tanggal Produksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data_produksi as $key => $data_produksi)
                                @php
                                    $dataBulan = strtolower(date('F', strtotime($data_produksi->tanggal)));
                                    $filterBulan = strtolower(date('F', strtotime($selectedMonth)));
                                @endphp
            
                                @if($dataBulan === $filterBulan)
                                    <tr class="data-row" data-bulan="{{ $dataBulan }}">
                                        <td>{{$key+1}}</td>
                                        <td>{{$data_produksi->proses}}</td>
                                        <td>{{$data_produksi->target_quantity}}</td>
                                        <td>{{$data_produksi->quantity}}</td>
                                        <td>{{$data_produksi->finish_good}}</td>
                                        <td>{{$data_produksi->reject}}</td>
                                        <td>{{ formatDate($data_produksi->operating_time) }}</td>
                                        <td>{{ formatDate($data_produksi->actual_time) }}</td>
                                        <td>{{ formatDate($data_produksi->down_time) }}</td>
                                        <td>{{ \Carbon\Carbon::parse($data_produksi->tanggal)->format('F, Y') }}</td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            
        </div>
    </div>
</div>
@php
function formatDate($time) {
    $formattedTime = '';

    if ($time) {
        $timeComponents = explode(':', $time);
        $hours = intval($timeComponents[0]);
        $minutes = intval($timeComponents[1]);
        $seconds = intval($timeComponents[2]);

        // Menghitung total waktu dalam hitungan menit
        $totalMinutes = ($hours * 60) + $minutes + ($seconds / 60);

        // Cek jika total menit tidak sama dengan 0, baru format dan tampilkan
        if ($totalMinutes !== 0) {
            $formattedTime = "{$totalMinutes} Menit";
        }
    }

    return $formattedTime;
}
@endphp
@stop   
@push('js')
<script>
</script>
@endpush