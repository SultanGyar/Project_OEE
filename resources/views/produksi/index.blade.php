@extends('adminlte::page')

@section('title', 'Daftar Produksi')

@section('content_header')
<h1 class="m-0 text-dark">Daftar Produksi</h1>
@stop

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="card-header">
                    <h4 class="card-title-center text-center text-dark">Perfomance</h4>
                </div>
                <p></p>
                <div class="btn-group">
                    <a href="{{ route('produksi.create') }}" class="text-btn-center btn btn-sm btn-primary mb-2"
                        style="height: 38px;">Tambah</a>

                    <div class="form-group ml-2">
                        <input type="month" class="form-control" id="selectBulan">
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover table-bordered table-striped" id="example1">
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
                            @foreach($produksi as $key => $item)
                            <tr class="data-row" data-bulan="{{ strtolower(date('F', strtotime($item->tanggal))) }}">
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $item->fuser->name }}</td>
                                <td>{{ $item->proses }}</td>
                                <td>{{ date('d-F-Y', strtotime($item->tanggal)) }}</td>
                                <td>{{ $item->target_quantity }}</td>
                                <td>{{ $item->quantity }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <p></p>
                <div class="card-header">
                    <h4 class="card-title-center text-center text-dark">Availability</h4>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover table-bordered table-striped" id="example2">
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
                            @foreach($produksi as $key => $item)
                            <tr class="data-row" data-bulan="{{ strtolower(date('F', strtotime($item->tanggal))) }}">
                                <td>{{ $key + 1 }}</td>
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
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <p></p>
                <div class="card-header">
                    <h4 class="card-title-center text-center text-dark+">Quality</h4>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover table-bordered table-striped" id="example3">
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
                            @foreach($produksi as $key => $item)
                            <tr class="data-row" data-bulan="{{ strtolower(date('F', strtotime($item->tanggal))) }}">
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $item->fuser->name }}</td>
                                <td>{{ $item->proses }}</td>
                                <td>{{ date('d-F-Y', strtotime($item->tanggal)) }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>{{ $item->finish_good }}</td>
                                <td>{{ $item->reject }}</td>
                                <td>{{ $item->keterangan }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
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

$formattedTime = '';

if ($hours > 0) {
$formattedTime .= $hours . ' Hours ';
}

if ($minutes > 0) {
$formattedTime .= $minutes . ' minutes ';
}

if ($seconds > 0) {
$formattedTime .= $seconds . ' seconds';
}
}
return $formattedTime;
}
@endphp

@push('js')

<script>
    $('#example1').DataTable({
        "responsive": true,
    });
    $('#example2').DataTable({
        "responsive": true,
    });
    $('#example3').DataTable({
        "responsive": true,
    });
</script>
@endpush