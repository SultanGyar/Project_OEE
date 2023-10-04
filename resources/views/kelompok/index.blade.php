@extends('adminlte::page')
@section('title', ' Daftar Kelompok')

@section('content_header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Daftar Kelompok</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Daftar Kelompok</li>
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
                    <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
                        <a href="#" class="text-btn-center btn btn-md btn-info mb-2 mb-md-0" style="height: 38px;"
                            data-toggle="modal" data-target="#modalTambah">Tambah</a>
                    </div>
                    <div class="table-responsive"> 
                        <table class="table table-hover table-bordered table-striped" id="example2">
                            <thead>
                                <tr style="text-align: center; background-color: #069eb5;">
                                    <th>Kelompok</th>
                                    <th>Nama Proses</th>
                                    <th>Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($kelompok as $data)
                                <tr>
                                    <td>{{ $data->nama_kelompok }}</td>
                                    <td>{{ $data->proses_kelompok }}</td>
                                    <td>
                                        <a href="#" class="btn btn-info btn-xs" data-toggle="modal" data-target="#modalEdit{{ $data->id }}">
                                            Edit
                                        </a>
                                        <a href="{{ route('kelompok.destroy', $data) }}" onclick="notificationBeforeDelete(event, this)"
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
            <form action="{{ route('kelompok.store') }}" method="post">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTambahLabel">Tambah Anggota</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="proses_kelompok">Nama Proses</label>
                        <select class="form-control @error('proses_kelompok') is-invalid @enderror" id="proses_kelompok" name="proses_kelompok">
                            <option value="" selected disabled>Pilih Proses</option>
                            @foreach ($dataproses as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('proses_kelompok')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="nama_kelompok">Kelompok</label>
                        <select class="form-control @error('nama_kelompok') is-invalid @enderror" id="nama_kelompok" name="nama_kelompok">
                            <option value=""selected disabled>Pilih Kelompok</option>
                            <option value="Ring 1" {{ old('nama_kelompok') === 'Ring 1' ? 'selected' : '' }}>Ring 1</option>
                            <option value="Ring 2" {{ old('nama_kelompok') === 'Ring 2' ? 'selected' : '' }}>Ring 2</option>
                            <option value="DJG" {{ old('nama_kelompok') === 'DJG' ? 'selected' : '' }}>DJG</option>
                            <option value="Ring 3" {{ old('nama_kelompok') === 'Ring 3' ? 'selected' : '' }}>Ring 3</option>
                            <option value="Sealing Element" {{ old('nama_kelompok') === 'Sealing Element' ? 'selected' : '' }}>Sealing Element</option>
                        </select>
                        @error('nama_kelompok')
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

@foreach($kelompok as $data)
<!-- Modal Edit -->
<div class="modal fade" id="modalEdit{{ $data->id }}" tabindex="-1" role="dialog" aria-labelledby="modalEditLabel{{ $data->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('kelompok.update', $data->id) }}" method="post">
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
                        <label for="edit_nama_kelompok">Kelompok</label>
                        <select class="form-control @error('nama_kelompok') is-invalid @enderror" id="edit_nama_kelompok" name="nama_kelompok">
                            <option value="" disabled>Pilih Kelompok</option>
                            <option value="Ring 1" {{ $data->nama_kelompok === 'Ring 1' ? 'selected' : '' }}>Ring 1</option>
                            <option value="Ring 2" {{ $data->nama_kelompok === 'Ring 2' ? 'selected' : '' }}>Ring 2</option>
                            <option value="DJG" {{ $data->nama_kelompok === 'DJG' ? 'selected' : '' }}>DJG</option>
                            <option value="Ring 3" {{ $data->nama_kelompok === 'Ring 3' ? 'selected' : '' }}>Ring 3</option>
                            <option value="Sealing Element" {{ $data->nama_kelompok === 'Sealing Element' ? 'selected' : '' }}>Sealing Element</option>
                        </select>
                        @error('nama_kelompok')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="proses_kelompok{{ $data->id }}">Nama Proses</label>
                        <select class="form-control @error('proses_kelompok') is-invalid @enderror" id="proses_kelompok{{ $data->id }}" name="proses_kelompok">
                            <option value="">Pilih Proses</option>
                            @foreach ($dataproses as $value => $label)
                                <option value="{{ $value }}" {{ $data->proses_kelompok == $value ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                        @error('proses_kelompok')
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
