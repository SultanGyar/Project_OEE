@extends('adminlte::page')
@section('title', 'Target Quantity')

@section('content_header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Target Quantity</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Target Quantity</li>
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
                    <h3 class="card-title" style="color: white">Target Quantity</h3>
                </div>
                <div class="card-body">
                    <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
                        <a href="{{ route('target.create') }}" class="text-btn-center btn btn-md btn-info mb-2 mb-md-0"
                            style="height: 38px;">Tambah</a>
                        <form id="filterForm" method="get" class="form-inline">
                            @php
                            $currentDate = date('Y-m-d');
                            $selectedDate = request('filterDate', $currentDate);
                            @endphp
                            <div class="d-flex align-items-center">
                                <label for="filterDate" class="mr-2">Tanggal:</label>
                                <input type="date" class="form-control" id="filterDate" name="filterDate"
                                    value="{{ $selectedDate }}" max="{{ $currentDate }}">
                                <button type="submit" class="btn btn-info ml-2">Submit</button>
                            </div>
                        </form>
                    </div>
                    <div class="table">
                        <table class="table table-hover table-bordered table-striped" id="example2">
                            <thead>
                                <tr style="text-align: center; background-color: #069eb5;">
                                    <th>Proses</th>
                                    <th>Tanggal</th>
                                    <th>Target Quantity</th>
                                    <th>Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($target as $data)
                                @php
                                $dataTanggal = date('Y-m-d', strtotime($data->tanggal_target));
                                @endphp
                                @if($dataTanggal === $selectedDate)
                                <tr>
                                    <td>{{ $data->target_proses }}</td>
                                    <td>{{ $data->tanggal_target }}</td>
                                    <td>{{ $data->target_quantity_byadmin }}</td>
                                    <td>
                                        <a href="{{ route('target.edit', $data) }}" class="btn btn-primary btn-xs">
                                            Edit
                                        </a>
                                        <a href="{{ route('target.destroy', $data) }}"
                                            onclick="notificationBeforeDelete(event, this)" class="btn btn-danger btn-xs">
                                            Delete
                                        </a>
                                    </td>
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
@stop
@push('js')
<script>

    $(document).ready(function () {
        $('#example2').DataTable({
            "responsive": true,
            "scrollY" : true,
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
