@extends('adminlte::page')
@section('title', 'Monthly Production')
<link rel="icon" href="{{ asset('vendor/adminlte/dist/img/icon-title.png') }}" type="image/png">
@section('content_header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Data Produksi Bulanan</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Data Produksi Bulanan</li>
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
                <div class="card-header bg-gradient-gray-dark">
                    <h3 class="card-title" style="color: white">Data Produksi Bulanan</h3>
                </div>
                <div class="card-body">
                    <div class="d-flex flex-wrap justify-content-between align-items-center mb-2">
                        <form id="filterForm" method="get" class="form-inline mb-0">
                            @php
                            $currentYear = date('Y');
                            $currentMonth = date('m');
                            $currentDate = "{$currentYear}-{$currentMonth}";
                            $selectedMonth = request('filterMonth', $currentDate);
                            @endphp
                            <label for="filterMonth" class="mr-1 mt-1">Pilih :</label>
                            <input type="month" class="form-control mt-1" id="filterMonth" style="width: 55%"
                                name="filterMonth" value="{{ $selectedMonth }}" max="{{ $currentDate }}">
                            <button type="submit" class="btn btn-info ml-2 mt-1">Submit</button>
                        </form>
                        @can('admin-only')
                        <button id="exportOptions" class="btn btn-secondary mt-1 dropdown-toggle" type="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Export
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" data-value="excel">
                                <i class="fas fa-file-excel"></i> Excel
                            </a>
                            <a class="dropdown-item" data-value="print">
                                <i class="fas fa-print"></i> Print
                            </a>
                            <a class="dropdown-item" data-value="csv">
                                <i class="fas fa-file-csv"></i> CSV
                            </a>
                            <a class="dropdown-item" data-value="pdf">
                                <i class="fas fa-file-pdf"></i> PDF
                            </a>
                        </div>
                        @endcan
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered table-striped" style="width:100%" id="example2">
                            <thead>
                                <tr style="text-align: center; background-color: #069eb5;">
                                    <th>No.</th>
                                    <th>Proses</th>
                                    <th>Kelompok</th>
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
                                @php
                                $no = 1; // Inisialisasi nomor urut
                                @endphp
                                @foreach($data_produksi as $key => $data)
                                @php
                                $dataBulan = strtolower(date('F', strtotime($data->tanggal)));
                                $filterBulan = strtolower(date('F', strtotime($selectedMonth)));
                                @endphp

                                @if($dataBulan === $filterBulan)
                                <tr class="data-row" data-bulan="{{ $dataBulan }}">
                                    <td>{{$no}}</td>
                                    <td>{{$data->proses}}</td>
                                    <td>{{$data->kelompokan}}</td>
                                    <td>{{$data->target_quantity}}</td>
                                    <td>{{$data->quantity}}</td>
                                    <td>{{$data->finish_good}}</td>
                                    <td>{{$data->reject}}</td>
                                    <td>{{ formatTime($data->operating_time) }}</td>
                                    <td>{{ formatTime($data->actual_time) }}</td>
                                    <td>{{ formatTime($data->down_time) }}</td>
                                    <td>{{ \Carbon\Carbon::parse($data->tanggal)->format('F, Y') }}</td>
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

@stop

@php
include_once(app_path('helper/helpers.php'))
@endphp

@push('js')
<script src="{{ asset('plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/jszip/jszip.min.js') }}"></script>
<script src="{{ asset('plugins/pdfmake/pdfmake.min.js') }}"></script>
<script src="{{ asset('plugins/pdfmake/vfs_fonts.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>

<script>
    $(document).ready(function () {
        var exportColumns = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];
        var currentDate = new Date();
        var formattedDate = currentDate.toLocaleString('id-ID', {
            year: 'numeric',
            month: 'long'
        });
        var table = $('#example2').DataTable({
            "responsive": true,
            "scrollX": true,
            buttons: [
                {
                    extend: "excel",
                    text: "Excel",
                    title: "Data OEE " + formattedDate, 
                    exportOptions: {
                        columns: exportColumns
                    }
                },
                {
                    extend: "csv",
                    text: "CSV",
                    title: "Data OEE " + formattedDate,
                    exportOptions: {
                        columns: exportColumns
                    }
                },
                {
                    extend: "pdf",
                    text: "PDF", 
                    title: "Data OEE " + formattedDate, 
                    exportOptions: {
                        columns: exportColumns
                    }
                },
                {
                    extend: "print",
                    text: "Print",
                    title: "Data OEE " + formattedDate, 
                    exportOptions: {
                        columns: exportColumns
                    }
                }
            ]
        });

        $('.dropdown-item').click(function() {
            var selectedValue = $(this).data('value');

            if (selectedValue === 'excel') {
                table.button(0).trigger(); // Mengaktifkan tombol Excel
            } else if (selectedValue === 'csv') {
                table.button(1).trigger(); // Mengaktifkan tombol CSV
            } else if (selectedValue === 'pdf') {
                table.button(2).trigger(); // Mengaktifkan tombol PDF
            } else if (selectedValue === 'print') {
                table.button(3).trigger(); // Mengaktifkan tombol Print
            }
        });
    });
</script>

@endpush