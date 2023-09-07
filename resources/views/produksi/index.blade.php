@extends('adminlte::page')

@section('title', 'Daftar Produksi')

@section('content_header')
<h1 class="m-0 text-dark">Daftar Produksi</h1>
@stop

@section('content')
<div class="row">
    <div class="col">  
        <div class="card">
            <div class="card-body">
                <div class="btn-group mb-2 mt-2">
                    <a href="{{ route('produksi.create') }}" class="text-btn-center btn btn-md btn-primary"
                        style="height: 38px;">Tambah</a>
                    {{-- <a href="#" class="text-btn-center btn btn-md btn-danger ml-2"
                        style="height: 38px;">Export PDF</a> --}}
                    <input type="month" class="form-control ml-2" id="selectBulan">
                </div>

                @foreach(['example1', 'example2', 'example3'] as $tableId)

                    <div class="table-responsive mt-2">
                        <div class="card-header mb-2">
                            <h4 class="card-title-center text-center text-dark">
                                @if($tableId === 'example1')
                                    Performance
                                @elseif($tableId === 'example2')
                                    Availability
                                @else
                                    Quality
                                @endif
                            </h4>
                        </div>
                        @php
                            $previousMonth = ''; 
                        @endphp
                        <table class="table table-col-12 table-hover table-bordered table-striped " id="{{ $tableId }}">
                            <thead>
                                <tr style="text-align: center; background-color: 
                                    {{ $tableId === 'example1' ? '#28a745' : ($tableId === 'example2' ? '#ffc107' : '#dc3545') }};">
                                    <th>No.</th>
                                    <th>Operator</th>
                                    <th>Proses</th>
                                    <th>Tanggal</th>
                                    @if($tableId === 'example1')
                                        <th>Target Quantity</th>
                                        <th>Actual Quantity</th>
                                    @elseif($tableId === 'example2')
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
                                        <th>Actual Quantity</th>
                                        <th>Good Quality</th>
                                        <th>Not Good</th>
                                        <th>Keterangan</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($produksi as $key => $item)
                                @php
                                    $currentMonth = strtolower(date('Y-m', strtotime($item->tanggal))); 
                                @endphp

                                @if($currentMonth !== $previousMonth)
                                    @php
                                        $previousMonth = $currentMonth; 
                                        $rowNumber = 1; 
                                    @endphp
                                @endif
                                <tr class="data-row" data-bulan="{{ strtolower(date('Y-m-d', strtotime($item->tanggal))) }}">
                                    <td>{{ $rowNumber }}</td>
                                    <td>{{ $item->fuser->name }}</td>
                                    <td>{{ $item->proses }}</td>
                                    <td>{{ date('d-F-Y', strtotime($item->tanggal)) }}</td>
                                    @if($tableId === 'example1')
                                        <td>{{ $item->target_quantity }}</td>
                                        <td>{{ $item->quantity }}</td>
                                    @elseif($tableId === 'example2')
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
                                    @else
                                        <td>{{ $item->quantity }}</td>
                                        <td>{{ $item->finish_good }}</td>
                                        <td>{{ $item->reject }}</td>
                                        <td>{{ $item->keterangan }}</td>
                                    @endif
                                </tr>
                                    @php
                                        $rowNumber++; 
                                    @endphp
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                <p></p>
                @endforeach
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
        const selectBulan = document.getElementById("selectBulan");

        // Mendapatkan tanggal saat ini
        const today = new Date();
        const currentYear = today.getFullYear();
        const currentMonth = today.getMonth() + 1; // Bulan dimulai dari 0 (Januari) - 11 (Desember)

        // Set nilai bulan saat ini pada input
        selectBulan.value = `${currentYear}-${String(currentMonth).padStart(2, '0')}`;

        // Memfilter data berdasarkan bulan yang dipilih saat halaman dimuat
        const selectedDate = new Date(selectBulan.value);
        const selectedYear = selectedDate.getFullYear();
        const selectedMonth = selectedDate.getMonth() + 1;
        filterDataByMonth(selectedYear, selectedMonth);

        // Fungsi untuk memfilter data berdasarkan bulan
        selectBulan.addEventListener("change", function () {
            const selectedDate = new Date(selectBulan.value);
            const selectedYear = selectedDate.getFullYear();
            const selectedMonth = selectedDate.getMonth() + 1;

            // Memfilter data berdasarkan bulan yang dipilih
            filterDataByMonth(selectedYear, selectedMonth);
        });

        // Fungsi untuk memfilter data berdasarkan bulan yang dipilih
        function filterDataByMonth(year, month) {
            const rows = document.querySelectorAll('.data-row');

            rows.forEach(row => {
                const dataBulan = row.getAttribute('data-bulan');
                const [dataYear, dataMonth] = dataBulan.split('-');

                if (parseInt(dataYear) === year && parseInt(dataMonth) === month) {
                    row.style.display = 'table-row';
                } else {
                    row.style.display = 'none';
                }
            });

            // Setelah pemfilteran, panggil ulang DataTable untuk merender ulang tabel
            for (const tableId of ['example1', 'example2', 'example3']) {
                $('#' + tableId).DataTable().destroy();
                $('#' + tableId).DataTable({
                    "responsive": true,
                });
            }
        }
    });
</script>

@endpush
