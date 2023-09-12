@extends('adminlte::page')
@section('title', 'Daftar Keterangan')

@section('content_header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Daftar Keterangan</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Daftar Keterangan</li>
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
                    <h3 class="card-title" style="color: white">Daftar Keterangan</h3>
                </div>
                <div class="card-body">
                    <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
                        <a href="#" class="text-btn-center btn btn-md btn-info mb-2 mb-md-0" style="height: 38px;" data-toggle="modal" data-target="#modalTambah">Tambah</a>
                    </div>
                    <div class="table">
                        <table class="table table-hover table-bordered table-striped" id="example2">
                            <thead>
                                <tr style="text-align: center; background-color: #069eb5;">
                                    <th>Daftar Keterangan</th>
                                    <th>Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($tbketerangan as $data)
                                <tr>
                                    <td>{{ $data->daftarketerangan }}</td>
                                    <td>
                                        <a href="#}" class="btn btn-info btn-xs" 
                                            onclick="openEditModal('{{ route('tbketerangan.edit', $data) }}', '{{ $data->daftarketerangan }}')"
                                            data-toggle="modal" data-target="#modalEdit_{{ $data->id }}">
                                            Edit
                                        </a>
                                        <a href="{{ route('tbketerangan.destroy', $data) }}"
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
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="modalTambah" tabindex="-1" role="dialog" aria-labelledby="modalTambahLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('tbketerangan.store') }}" method="post">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTambahLabel">Tambah Keterangan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="daftarketerangan">Tambahkan Daftar Keterangan</label>
                        <input type="text" class="form-control" id="daftarketerangan" name="daftarketerangan" required>
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
<!-- Modal Edit -->
<div class="modal fade" id="modalEdit_{{ $data->id }}" tabindex="-1" role="dialog" aria-labelledby="modalEditLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('tbketerangan.update', $data) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditLabel">Edit Keterangan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="daftarketerangan">Edit Daftar Keterangan</label>
                        <input type="text" class="form-control" id="daftarketerangan_{{ $data->id }}" name="daftarketerangan" required
                        value="{{ old('daftarketerangan', $data->daftarketerangan) }}" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-info">Simpan Perubahan</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>
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
    });

    function openEditModal(url, daftarketerangan) {
        $('#daftarketerangan_{{ $data->id }}').val(daftarketerangan);
        $('#editForm').attr('action', url);
        $('#modalEdit_{{ $data->id }}').modal('show');
    }

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
