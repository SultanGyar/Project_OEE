@extends('adminlte::page')
@section('title', 'Recap Produksi')
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
                    <div class="btn-group mb-2">
                        <form id="filterForm" method="get" class="form-inline">
                            @php
                            $currentYear = date('Y');
                            $currentMonth = date('m');
                            $currentDate = "{$currentYear}-{$currentMonth}";
                            $selectedMonth = request('filterMonth', $currentDate);
                            @endphp
                            <label for="filterMonth" class="mr-1">Pilih :</label>
                            <input type="month" class="form-control" id="filterMonth" style="width: 55%" name="filterMonth"
                                value="{{ $selectedMonth }}" max="{{ $currentDate }}">
                            <button type="submit" class="btn btn-info ml-2">Submit</button>
                        </form>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered table-striped" style="width:100%" id="example2">
                            <thead>
                                <tr style="text-align: center; background-color: #069eb5;">
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
</div>
@php
    function formatDate($time) {
        $formattedTime = '';
        if ($time) {
        $timeComponents = explode(':', $time);
        $hours = intval($timeComponents[0]);
        $minutes = intval($timeComponents[1]);
        $seconds = intval($timeComponents[2]);

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
<script src="{{ asset('plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/jszip/jszip.min.js') }}"></script>
<script src="{{ asset('plugins/pdfmake/pdfmake.min.js') }}"></script>
<script src="{{ asset('plugins/pdfmake/vfs_fonts.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>

<script>
    $(document).ready(function () {
            var table = $('#example2').DataTable({
                "responsive": true,
                "scrollX": true,
            })

            function notificationBeforeDelete(event, el) {
                event.preventDefault();
                if (confirm('Apakah anda yakin akan menghapus data ? ')) {
                    $("#delete-form").attr('action', $(el).attr('href'));
                    $("#delete-form").submit();
                }
            }
        });
</script>

<form action="" id="delete-form" method="post">
    @method('delete')
    @csrf
</form>

@endpush