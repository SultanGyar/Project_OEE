@extends('adminlte::page')
@section('title', ' Daftar Anggota Kelompok')
<link rel="icon" href="{{ asset('vendor/adminlte/dist/img/icon-title.png') }}" type="image/png">
@section('content_header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Daftar Anggota Kelompok</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Daftar Anggota Kelompok</li>
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
                    <h3 class="card-title" style="color: white">Daftar Anggota Kelompok</h3>
                </div>
                <div class="card-body">
                    <div class="d-flex flex-wrap justify-content-between align-items-center mb-2">
                        <a href="#" class="text-btn-center btn btn-md btn-info"
                            data-toggle="modal" data-target="#modalTambah">Tambah</a>
                    </div>
                    <div class="table-responsive"> 
                        <table class="table table-hover table-bordered table-striped" style="width: 100%" id="example2">
                            <thead>
                                <tr style="text-align: center; background-color: #069eb5;">
                                    <th>Nama Proses</th>
                                    <th>Kelompok</th>
                                    <th>Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($anggota_kelompok as $data)
                                <tr>
                                    <td>{{ $data->daftarproses }}</td>
                                    <td>{{ $data->daftarkelompok }}</td>
                                    <td>
                                        <a href="#" class="btn btn-info btn-xs" data-toggle="modal" data-target="#modalEdit{{ $data->id }}">
                                            Edit
                                        </a>
                                        <a href="{{ route('anggota_kelompok.destroy', $data) }}" onclick="notificationBeforeDelete(event, this)"
                                            class="btn btn-danger btn-xs">
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
</div>


<!-- Modal Tambah -->
<div class="modal fade" id="modalTambah" tabindex="-1" role="dialog" aria-labelledby="modalTambahLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('anggota_kelompok.store') }}" method="post" id="anggotaForm">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTambahLabel">Tambah Anggota</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="daftarproses">Nama Proses<span class="font-weight-normal text-danger">*</label>
                        <select class="form-control @error('daftarproses') is-invalid @enderror" id="daftarproses" name="daftarproses">
                            <option value="" selected disabled>Pilih Proses</option>
                            @foreach ($dataproses as $value => $label)
                                <option value="{{ $value }}" @if (old('daftarproses') == $value) selected @endif>{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('daftarproses')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="daftarkelompok">Kelompok<span class="font-weight-normal text-danger">*</label>
                        <select class="form-control @error('daftarkelompok') is-invalid @enderror" id="daftarkelompok" name="daftarkelompok">
                            <option value="" selected disabled>Pilih Kelompok</option>
                            @foreach ($datakelompok as $value => $label)
                                <option value="{{ $value }}" @if (old('daftarkelompok') == $value) selected @endif>{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('daftarkelompok')
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

@foreach($anggota_kelompok as $data)
<!-- Modal Edit -->
<div class="modal fade" id="modalEdit{{ $data->id }}" tabindex="-1" role="dialog" aria-labelledby="modalEditLabel{{ $data->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('anggota_kelompok.update', $data->id) }}" method="post">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditLabel{{ $data->id }}">Edit Anggota</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="daftarproses{{ $data->id }}">Nama Proses<span class="font-weight-normal text-danger">*</label>
                        <select class="form-control @error('daftarproses') is-invalid @enderror" id="daftarproses{{ $data->id }}" name="daftarproses">
                            <option value="">Pilih Proses</option>
                            @foreach ($dataproses as $value => $label)
                                <option value="{{ $value }}" {{ $data->daftarproses == $value ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                        @error('daftarproses')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="daftarkelompok">Kelompok<span class="font-weight-normal text-danger">*</label>
                        <select class="form-control @error('daftarkelompok') is-invalid @enderror" id="daftarkelompok{{ $data->id }}" name="daftarkelompok">
                            <option value="">Pilih Proses</option>
                            @foreach ($datakelompok as $value => $label)
                                <option value="{{ $value }}" {{ $data->daftarkelompok == $value ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                        @error('daftarkelompok')
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
@endforeach

@stop

@push('js')
<script>

    $(document).ready(function () {
        $('#example2').DataTable({
            "responsive": true,
            "scrollX": true,
        });
        
        $('#modalTambah').on('hidden.bs.modal', function () {
            $('#anggotaForm')[0].reset();
            $('.is-invalid').removeClass('is-invalid');
            $('.text-danger').remove();
        });

        if ($('.is-invalid').length > 0) {
            $('#modalTambah').modal('show');
        }

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
