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
                        <a href="#" class="text-btn-center btn btn-md btn-info mb-2 mb-md-0" style="height: 38px;"
                            data-toggle="modal" data-target="#modalTambah">Tambah</a>
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
                                        <a href="#" class="btn btn-info btn-xs" data-toggle="modal" data-target="#modalEdit{{ $data->id }}">
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

<!-- Modal Tambah -->
<div class="modal fade" id="modalTambah" tabindex="-1" role="dialog" aria-labelledby="modalTambahLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('target.store') }}" method="post">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTambahLabel">Tambah Target</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="target_proses">Nama Proses</label>
                        <select class="form-control @error('target_proses') is-invalid @enderror" id="target_proses" name="target_proses">
                            <option value="" selected disabled>Pilih Proses</option>
                            @foreach ($dataproses as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('target_proses')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="tanggal_target">Tanggal</label>
                        <input type="date" class="form-control @error('tanggal_target') is-invalid @enderror"
                            id="tanggal_target" placeholder="tanggal_target" name="tanggal_target"
                            value="{{ old('tanggal_target') ?? date('Y-m-d') }}" readonly>
                        @error('tanggal_target')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="target_quantity_byadmin">Quantity</label>
                        <input type="number" class="form-control @error('target_quantity_byadmin') is-invalid @enderror"
                            id="target_quantity_byadmin" placeholder="Quantity" name="target_quantity_byadmin"
                            value="{{ old('target_quantity_byadmin') }}">
                        @error('target_quantity_byadmin')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-info">Simpan</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>

@foreach($target as $data)
<!-- Modal Edit -->
<div class="modal fade" id="modalEdit{{ $data->id }}" tabindex="-1" role="dialog" aria-labelledby="modalEditLabel{{ $data->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('target.update', $data->id) }}" method="post">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditLabel{{ $data->id }}">Edit Target</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="target_proses{{ $data->id }}">Nama Proses</label>
                        <select class="form-control @error('target_proses') is-invalid @enderror" id="target_proses{{ $data->id }}" name="target_proses">
                            <option value="">Pilih Proses</option>
                            @foreach ($dataproses as $value => $label)
                                <option value="{{ $value }}" {{ $data->target_proses == $value ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                        @error('target_proses')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="tanggal_target{{ $data->id }}">Tanggal</label>
                        <input type="date" class="form-control @error('tanggal_target') is-invalid @enderror"
                            id="tanggal_target{{ $data->id }}" placeholder="tanggal_target" name="tanggal_target"
                            value="{{$data->tanggal_target ?? old('tanggal_target') ?? date('Y-m-d') }}">
                        @error('tanggal_target')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="target_quantity_byadmin{{ $data->id }}">Target Quantity</label>
                        <input type="number" class="form-control @error('target_quantity_byadmin') is-invalid @enderror"
                            id="target_quantity_byadmin{{ $data->id }}" placeholder="Quantity" name="target_quantity_byadmin"
                            value="{{$data->target_quantity_byadmin ?? old('target_quantity_byadmin') }}">
                        @error('target_quantity_byadmin')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>   
                </div>
                <div class="modal-footer">
                    @if($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    <button type="submit" class="btn btn-info">Simpan</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

@stop
@push('js')
<script>

    $(document).ready(function () {
        $('#example2').DataTable({
            "responsive": true,
            "scrollY" : true,
        });

        $('#modalTambah').on('show.bs.modal', function (event) {
            $(this).find('form')[0].reset();
        });

        // Fungsi untuk membuka modal edit
        function openEditModal(id) {
            var modalId = '#modalEdit' + id;
            $(modalId).modal('show');
        }

        // Memanggil fungsi openEditModal saat tombol "Edit" ditekan
        $('.btn-edit').click(function () {
            var id = $(this).data('id');
            openEditModal(id);
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
