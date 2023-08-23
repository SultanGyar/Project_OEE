@extends('adminlte::page')
@section('title', 'Target Quantity')
@section('content_header')
<h1 class="m-0 text-dark">Target Quantity </h1>
@stop
@section('content')
@if(session('warning_message'))
    <div class="alert alert-warning">
        {{ session('warning_message') }}
    </div>
@endif
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="card-header">
                    <h4 class="card-title-center text-center text-dark">Target Quantity</h4>
                </div>
                <p></p>
                <div class="btn-group mb-2">
                    <a href="{{ route('target.create') }}" class="text-btn-center btn btn-md btn-primary"
                        style="height: 38px;">Tambah</a>

                    <input type="month" class="form-control ml-2" id="selectBulan">
                </div>
                <div class="table-responsive">
                    <table class="table table-hover table-bordered table-striped" id="example2">
                        <thead>
                            <tr style="text-align: center; background-color: #7b91bc;">
                                <th>Proses</th>
                                <th>Tanggal Target</th>
                                <th>Target Quantity</th>
                                <th>Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($target as $data)
                            <tr>
                                <td>{{ $data->target_proses }}</td>
                                <td>{{ $data->tanggal_target }}</td>
                                <td>{{ $data->target_quantity_byadmin }}</td>
                                <td>
                                    <a href="{{ route('target.edit', $data) }}" class="btn btn-primary btn-xs">
                                        Edit
                                    </a>

                                    <a href="{{ route('target.destroy', $data->id) }}"
                                        onclick="notificationBeforeDelete(event, this)" class="btn btn-danger btn-xs">
                                        Delete
                                    </a>
                                </td>
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
@push('js')
<form action="" id="delete-form" method="post">
    @method('delete')
    @csrf
</form>
<script>
    $('#example2').DataTable({
    "responsive": true,
    });

    function notificationBeforeDelete(event, el) {
        event.preventDefault();
        if (confirm('Apakah anda yakin akan menghapus data ? ')) {
            $("#delete-form").attr('action', $(el).attr('href'));
            $("#delete-form").submit();
        }
    }

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
            const rows = document.querySelectorAll('#example2 tbody tr');

            rows.forEach(row => {
                const dataTahun = row.cells[1].textContent.split('-')[0];
                const dataBulan = row.cells[1].textContent.split('-')[1];

                if (parseInt(dataTahun) === year && parseInt(dataBulan) === month) {
                    row.style.display = 'table-row';
                } else {
                    row.style.display = 'none';
                }
            });
            
            // Panggil ulang DataTable untuk merender ulang tabel
            $('#example2').DataTable().destroy();
            $('#example2').DataTable({
                "responsive": true,
            });
        }
    });
</script>
@endpush