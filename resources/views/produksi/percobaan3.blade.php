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
                    <h4 class="card-title-center text-center text-dark">Data Produksi Harian</h4>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover table-bordered table-striped" id="example2">
                        <thead>
                            <tr style="text-align: center; background-color: #28a745;">
                                <th>No.</th>
                                <th>Nama Operator</th>
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

                    <table class="table table-hover table-bordered table-striped" id="example2">
                        <thead>
                            <tr style="text-align: center; background-color: #ffc107;">
                                <th>No.</th>
                                <th>Nama Operator</th>
                                <th>Proses</th>
                                <th>Tanggal</th>
                                <th>Operating Time</th>
                                <th>Actual Time</th>
                                <th>Down Time</th>
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
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <table class="table table-hover table-bordered table-striped" id="example2">
                    <thead>
                        <tr style="text-align: center; background-color: #dc3545;">
                            <th>No.</th>
                            <th>Nama Operator</th>
                            <th>Proses</th>
                            <th>Tanggal</th>
                            <th>Quantity</th>
                            <th>Good Quality</th>
                            <th>Rejected</th>
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
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</div>
</div>

<script>
    // Mendapatkan elemen filter
    var filterBulanButton = document.getElementById("filterBulan");
    var filterBulanSelect = document.querySelectorAll(".dropdown-item");

    // Menambahkan event listener pada tombol filter bulan
    filterBulanButton.addEventListener("click", function () {
        this.classList.toggle("active");
        var dropdownMenu = this.nextElementSibling;
        dropdownMenu.classList.toggle("show");
    });

    // Menambahkan event listener untuk setiap pilihan bulan
    filterBulanSelect.forEach(function (item) {
        item.addEventListener("click", function () {
            var selectedMonth = this.getAttribute("data-value");
            var rows = document.querySelectorAll("#example2 tbody tr");

            // Menggunakan loop untuk mengatur tampilan baris berdasarkan bulan yang dipilih
            for (var i = 0; i < rows.length; i++) {
                var rowBulan = rows[i].getAttribute("data-bulan");
                if (selectedMonth === "" || rowBulan.includes(selectedMonth.toLowerCase())) {
                    rows[i].style.display = "";
                } else {
                    rows[i].style.display = "none";
                }
            }

            // Ubah teks pada tombol filter bulan menjadi bulan yang dipilih
            filterBulanButton.innerHTML = this.innerHTML;
            filterBulanButton.classList.remove("active");
            var dropdownMenu = this.parentNode;
            dropdownMenu.classList.remove("show");
        });
    });
</script>
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
    $('#example2').DataTable({
        "responsive": true,
    });
</script>
@endpush