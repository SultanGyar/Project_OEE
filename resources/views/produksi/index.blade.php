@extends('adminlte::page')
@section('title', 'Daftar Produksi')
<link rel="icon" href="{{ asset('vendor/adminlte/dist/img/icon-title.png') }}" type="image/png">
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
                    @can('admin-only')
                    <button class="btn btn-link text-white text-md mb-0 ml-auto btn-lanjutan">Lanjutan</button>
                    @endcan
                </div>

                <div class="card-body">
                    <div class="d-flex flex-wrap justify-content-between align-items-center mb-2">
                        <div style="display: flex; align-items: center; " >
                        <a href="{{ route('produksi.create') }}"
                            class="text-btn-center btn btn-md btn-info mb-2 " style="height: 38px;">Tambah</a>
                            @can('admin-only')
                            <button type="button" class="btn btn-success ml-2 mb-2 " id="importButton">Import Data</button>
                            @endcan
                        </div>
                        <form id="filterForm" method="get" class="form-inline">
                            @php
                            $currentDate = date('Y-m-d');
                            $selectedDate = request('filterDate', $currentDate); // Ambil tanggal terpilih
                            @endphp
                            <div class="d-flex align-items-center">
                                <label for="filterDate" class="mr-2 mb-2 mb-md-0"
                                    style="flex: 0 0 auto;">Tanggal:</label>
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
                                    <th>Tanggal</th>
                                    <th>Proses</th>
                                    <th>Kelompok</th>
                                    <th>Size</th>
                                    <th>Class</th>
                                    <th>Kode</th>
                                    <th>Kapasitas /Pcs</th>
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
                                    @can('admin-only')
                                    <th>Opsi</th>
                                    @endcan
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
                                    <td>{{ $item->nama_user }}</td>
                                    <td>{{ date('d-F-Y', strtotime($item->tanggal)) }}</td>
                                    <td>{{ $item->daftarproses }}</td>
                                    <td>{{ $item->daftarkelompok }}</td>
                                    <td>{{ $item->produk_size }}</td>
                                    <td>{{ $item->produk_class }}</td>
                                    <td>{{ $item->kode }}</td>
                                    <td>{{ $item->kapasitas_pcs }}</td>
                                    <td>{{ $item->target_quantity }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>{{ $item->finish_good }}</td>
                                    <td>{{ $item->reject }}</td>
                                    <td>{{ $item->daftarketerangan }}</td>
                                    <td>{{ formatTime($item->operating_time) }}</td>
                                    <td>{{ formatTime($item->actual_time) }}</td>
                                    <td>{{ formatTime($item->down_time) }}</td>
                                    <td>{{ $item->a_time ? $item->a_time . ' Minutes' : '' }}</td>
                                    <td>{{ $item->b_time ? $item->b_time . ' Minutes' : '' }}</td>
                                    <td>{{ $item->c_time ? $item->c_time . ' Minutes' : '' }}</td>
                                    <td>{{ $item->d_time ? $item->d_time . ' Minutes' : '' }}</td>
                                    <td>{{ $item->e_time ? $item->e_time . ' Minutes' : '' }}</td>
                                    <td>{{ $item->f_time ? $item->f_time . ' Minutes' : '' }}</td>
                                    <td>{{ $item->g_time ? $item->g_time . ' Minutes' : '' }}</td>
                                    <td>{{ $item->h_time ? $item->h_time . ' Minutes' : '' }}</td>                                    
                                    @can('admin-only')
                                    <td >
                                        <a href="{{route('produksi.edit',
                                            $item)}}" class="btn btn-primary btn-xs">
                                            Edit
                                        </a>
                                        <a href="{{route('produksi.destroy', $item)}}"
                                            onclick="notificationBeforeDelete(event, this)"
                                            class="btn btn-danger btn-xs">
                                            Delete
                                        </a>
                                    </td>
                                    @endcan
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
            @can('admin-only')
            <div id="lanjutan" style="display: none;">
                @foreach (['Performance' => 'green', 'Availability' => 'warning', 'Quality' => 'danger'] as $header =>
                $color)
                <div class="card">
                    <div class="card-header bg-gradient-{{ $color }}">
                        <h3 class="card-title" style="color: white; width: 100%; text-align: center;">
                            {{ $header }}
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            @php
                            $tableId = 'example' . strtolower($header); // Menggunakan jenis header untuk menentukan ID
                            @endphp
                            <table class="table table-hover table-bordered table-striped" style="width: 100%"
                                id="{{ $tableId }}">
                                <thead>
                                    <tr
                                        style="text-align: center; background-color: #{{ $color == 'green' ? '28a745' : ($color == 'warning' ? 'ffc107' : 'dc3545') }}">
                                        <th>No.</th>
                                        <th>Operator</th>
                                        <th>Proses</th>
                                        <th>Tanggal</th>
                                        @if ($header == 'Performance')
                                        <th>Target Quantity</th>
                                        <th>Quantity</th>
                                        @elseif ($header == 'Availability')
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
                                        @else
                                        <th>Quantity</th>
                                        <th>Good Quality</th>
                                        <th>Not Good</th>
                                        <th>Keterangan</th>
                                        @endif
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
                                        <td>{{ $item->nama_user }}</td>
                                        <td>{{ $item->daftarproses }}</td>
                                        <td>{{ date('d-F-Y', strtotime($item->tanggal)) }}</td>
                                        @if ($header == 'Performance')
                                        <td>{{ $item->target_quantity }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        @elseif ($header == 'Availability')
                                        <td>{{ formatTime($item->operating_time) }}</td>
                                        <td>{{ formatTime($item->actual_time) }}</td>
                                        <td>{{ formatTime($item->down_time) }}</td>
                                        <td>{{ $item->a_time ? $item->a_time . ' Minutes' : '' }}</td>
                                        <td>{{ $item->b_time ? $item->b_time . ' Minutes' : '' }}</td>
                                        <td>{{ $item->c_time ? $item->c_time . ' Minutes' : '' }}</td>
                                        <td>{{ $item->d_time ? $item->d_time . ' Minutes' : '' }}</td>
                                        <td>{{ $item->e_time ? $item->e_time . ' Minutes' : '' }}</td>
                                        <td>{{ $item->f_time ? $item->f_time . ' Minutes' : '' }}</td>
                                        <td>{{ $item->g_time ? $item->g_time . ' Minutes' : '' }}</td>
                                        <td>{{ $item->h_time ? $item->h_time . ' Minutes' : '' }}</td>                                        
                                        @else
                                        <td>{{ $item->quantity }}</td>
                                        <td>{{ $item->finish_good }}</td>
                                        <td>{{ $item->reject }}</td>
                                        <td>{{ $item->daftarketerangan }}</td>
                                        @endif
                                    </tr>
                                    @php $no++; @endphp
                                    @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @endcan

        </div>
    </div>
</div>

<!-- Modal import excel-->
<div class="modal fade" id="modalImport" tabindex="-1" role="dialog" aria-labelledby="modalImportLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('produksi.import') }}" method="post" enctype="multipart/form-data" id="importForm">
                @csrf
                <div class="modal-header success">
                    <h5 class="modal-title" id="modalImportLabel">Import File</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <div class="input-group">
                            <input type="file" name="file">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <input type="submit" class="btn btn-success" value="Upload">
                    </div>
                </div>
            </form>
            
        </div>
    </div>
</div>
@stop

@php
include_once(app_path('helper/helpers.php'))
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

        $('table[id^="example"]').each(function () {
        if (!$(this).hasClass('dataTable')) {
            var table = $(this).DataTable({
                "responsive": true,
                "scrollX": false,
            });
        }

        $('#importButton').click(function() {
        $('#modalImport').modal('show');

        });
    });

    });

    function notificationBeforeDelete(event, el) {
        event.preventDefault();
        if (confirm('Apakah anda yakin akan menghapus data ? ')) {
            $("#delete-form").attr('action', $(el).attr('href'));
            $("#delete-form").submit();
        }
    }
</script>
<form action="" id="delete-form" method="post">
    @method('delete')
    @csrf
</form>
@endpush