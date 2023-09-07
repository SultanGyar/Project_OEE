@extends('adminlte::page')
@section('title', 'Daftar Produksi')
@section('content_header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Data Produksi Harian</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Data Produksi Harian</li>
            </ol>
        </div>
    </div>
</div>
@stop
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-gradient-gray-dark d-flex justify-content-between align-items-center">
                    <p class="card-title mb-0" style="color: white">Data Produksi Harian</p>
                    <button class="btn btn-link text-white text-md mb-0 ml-auto btn-lanjutan">Lanjutan</button>
                </div>

                <div class="card-body">
                    <div class="d-flex flex-wrap justify-content-between align-items-center mb-2">
                        <a href="{{ route('produksi.create') }}"
                            class="text-btn-center btn btn-md btn-info mb-2 mb-md-0" style="height: 38px;">Tambah</a>
                        <form id="filterForm" method="get" class="form-inline">
                            @php
                            $currentDate = date('Y-m-d');
                            $selectedDate = request('filterDate', $currentDate); // Ambil tanggal terpilih
                            @endphp
                            <div class="d-flex align-items-center">
                                <label for="filterDate" class="mr-2 mb-2 mb-md-0" style="flex: 0 0 auto;">Tanggal:</label>
                                <input type="date" class="form-control" id="filterDate" name="filterDate"
                                    value="{{ $selectedDate }}" max="{{ $currentDate }}">
                                <button type="submit" class="btn btn-info ml-2">Submit</button>
                            </div>
                        </form>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered table-striped" style="width: 100%" id="example">
                            <thead>
                                <tr style="text-align: center; background-color: #069eb5;">
                                    <th>No.</th>
                                    <th>Operator</th>
                                    <th>Proses</th>
                                    <th>Tanggal</th>
                                    <th>Target Quantity</th>
                                    <th>Actual Quantity</th>
                                    <th>Good Quality</th>
                                    <th>Not Good</th>
                                    <th>Keterangan</th>
                                    <th>Operating Time</th>
                                    <th>Actual Time</th>
                                    <th>Down Time</th>
                                    <th>A (Ganti Order)</th>
                                    <th>B (Repair)</th>
                                    <th>C (Material Tunggu)</th>
                                    <th>D (Operator)</th>
                                    <th>E (Maintenance)</th>
                                    <th>F (Checking)</th>
                                    <th>G (Reject)</th>
                                    <th>H (Rework)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $no = 1; // Inisialisasi nomor urut
                                @endphp
                                @foreach($produksi as $key => $item)
                                @php
                                $dataTanggal = date('Y-m-d', strtotime($item->tanggal)); // Ambil tanggal dari data
                                @endphp
                                @if($dataTanggal === $selectedDate)
                                <tr class="data-row"
                                    data-bulan="{{ strtolower(date('Y-m-d', strtotime($item->tanggal))) }}">
                                    <td>{{ $no }}</td>
                                    <td>{{ $item->fuser->name }}</td>
                                    <td>{{ $item->proses }}</td>
                                    <td>{{ date('d-F-Y', strtotime($item->tanggal)) }}</td>
                                    <td>{{ $item->target_quantity }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>{{ $item->finish_good }}</td>
                                    <td>{{ $item->reject }}</td>
                                    <td>{{ $item->keterangan }}</td>
                                    <td>{{ formatDate($item->operating_time) }}</td>
                                    <td>{{ formatDate($item->actual_time) }}</td>
                                    <td>{{ formatDate($item->down_time) }}</td>
                                    <td>{{ formatDate($item->a_time) }}</td>
                                    <td>{{ formatDate($item->b_time) }}</td>
                                    <td>{{ formatDate($item->c_time) }}</td>
                                    <td>{{ formatDate($item->d_time) }}</td>
                                    <td>{{ formatDate($item->e_time) }}</td>
                                    <td>{{ formatDate($item->f_time) }}</td>
                                    <td>{{ formatDate($item->g_time) }}</td>
                                    <td>{{ formatDate($item->h_time) }}</td>
                                </tr>
                                @php
                                $no++;
                                @endphp
                                @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div id="lanjutan" style="display: none;">
                <div class="card">
                    <div class="card-header bg-gradient-green">
                        <h3 class="card-title" style="color: white; width: 100%; text-align: center;">Performance</h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered table-striped" style="width: 100%"
                                id="example1">
                                <thead>
                                    <tr style="text-align: center; background-color: #28a745;">
                                        <th>No.</th>
                                        <th>Operator</th>
                                        <th>Proses</th>
                                        <th>Tanggal</th>
                                        <th>Target Quantity</th>
                                        <th>Quantity</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $no = 1; // Inisialisasi nomor urut
                                    @endphp
                                    @foreach($produksi as $key => $item)
                                    @php
                                    $dataTanggal = date('Y-m-d', strtotime($item->tanggal)); // Ambil tanggal dari data
                                    @endphp
                                    @if($dataTanggal === $selectedDate)
                                    <tr class="data-row"
                                        data-bulan="{{ strtolower(date('F', strtotime($item->tanggal))) }}">
                                        <td>{{ $no }}</td>
                                        <td>{{ $item->fuser->name }}</td>
                                        <td>{{ $item->proses }}</td>
                                        <td>{{ date('d-F-Y', strtotime($item->tanggal)) }}</td>
                                        <td>{{ $item->target_quantity }}</td>
                                        <td>{{ $item->quantity }}</td>
                                    </tr>
                                    @php
                                    $no++;
                                    @endphp
                                    @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header bg-gradient-warning">
                        <h3 class="card-title" style="color: white; width: 100%; text-align: center;">Availability</h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered table-striped" style="width: 100%"
                                id="example2">
                                <thead>
                                    <tr style="text-align: center; background-color: #ffc107;">
                                        <th>No.</th>
                                        <th>Operator</th>
                                        <th>Proses</th>
                                        <th>Tanggal</th>
                                        <th>Operating Time</th>
                                        <th>Actual Time</th>
                                        <th>Down Time</th>
                                        <th>A (Ganti Order)</th>
                                        <th>B (Repair)</th>
                                        <th>C (Material Tunggu)</th>
                                        <th>D (Operator)</th>
                                        <th>E (Maintenance)</th>
                                        <th>F (Checking)</th>
                                        <th>G (Reject)</th>
                                        <th>H (Rework)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $no = 1; // Inisialisasi nomor urut
                                    @endphp
                                    @foreach($produksi as $key => $item)
                                    @php
                                    $dataTanggal = date('Y-m-d', strtotime($item->tanggal)); // Ambil tanggal dari data
                                    @endphp
                                    @if($dataTanggal === $selectedDate)
                                    <tr class="data-row"
                                        data-bulan="{{ strtolower(date('F', strtotime($item->tanggal))) }}">
                                        <td>{{ $no }}</td>
                                        <td>{{ $item->fuser->name }}</td>
                                        <td>{{ $item->proses }}</td>
                                        <td>{{ date('d-F-Y', strtotime($item->tanggal)) }}</td>
                                        <td>{{ formatDate($item->operating_time) }}</td>
                                        <td>{{ formatDate($item->actual_time) }}</td>
                                        <td>{{ formatDate($item->down_time) }}</td>
                                        <td>{{ formatDate($item->a_time) }}</td>
                                        <td>{{ formatDate($item->b_time) }}</td>
                                        <td>{{ formatDate($item->c_time) }}</td>
                                        <td>{{ formatDate($item->d_time) }}</td>
                                        <td>{{ formatDate($item->e_time) }}</td>
                                        <td>{{ formatDate($item->f_time) }}</td>
                                        <td>{{ formatDate($item->g_time) }}</td>
                                        <td>{{ formatDate($item->h_time) }}</td>
                                    </tr>
                                    @php
                                    $no++;
                                    @endphp
                                    @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header bg-gradient-danger">
                        <h3 class="card-title" style="color: white; width: 100%; text-align: center;">Quality</h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered table-striped" style="width: 100%"
                                id="example3">
                                <thead>
                                    <tr style="text-align: center; background-color: #dc3545;">
                                        <th>No.</th>
                                        <th>Operator</th>
                                        <th>Proses</th>
                                        <th>Tanggal</th>
                                        <th>Quantity</th>
                                        <th>Good Quality</th>
                                        <th>Not Good</th>
                                        <th>Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $no = 1; // Inisialisasi nomor urut
                                    @endphp
                                    @foreach($produksi as $key => $item)
                                    @php
                                    $dataTanggal = date('Y-m-d', strtotime($item->tanggal)); // Ambil tanggal dari data
                                    @endphp
                                    @if($dataTanggal === $selectedDate)
                                    <tr class="data-row"
                                        data-bulan="{{ strtolower(date('F', strtotime($item->tanggal))) }}">
                                        <td>{{ $no }}</td>
                                        <td>{{ $item->fuser->name }}</td>
                                        <td>{{ $item->proses }}</td>
                                        <td>{{ date('d-F-Y', strtotime($item->tanggal)) }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>{{ $item->finish_good }}</td>
                                        <td>{{ $item->reject }}</td>
                                        <td>{{ $item->keterangan }}</td>
                                    </tr>
                                    @php
                                    $no++;
                                    @endphp
                                    @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@stop

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

@push('js')
<script>

    document.addEventListener("DOMContentLoaded", function () {
        var lanjutanButton = document.querySelector(".btn-lanjutan");
        var lanjutanSection = document.getElementById("lanjutan");

        lanjutanButton.addEventListener("click", function () {
            if (lanjutanSection.style.display === "none") {
                lanjutanSection.style.display = "block";
            } else {
                lanjutanSection.style.display = "none";
            }
        });
    });

    $(document).ready(function () {
        var table = 
        $('#example').DataTable({
            "responsive": true,
            "scrollX": true,
        });


        function notificationBeforeDelete(event, el) {
            event.preventDefault();
            if (confirm('Apakah anda yakin akan menghapus data ? ')) {
                $("#delete-form").attr('action', $(el).attr('href'));
                $("#delete-form").submit();
            }
        }
    });
</script>
@endpush