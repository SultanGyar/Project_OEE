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
                                @foreach($keterangan as $data)
                                <tr>
                                    <td>{{ $data->daftarketerangan }}</td>
                                    <td>
                                        <a href="#" class="btn btn-info btn-xs" data-toggle="modal" data-target="#modalEdit{{ $data->id }}">
                                            Edit
                                        </a>
                                        <a href="{{ route('keterangan.destroy', $data) }}"
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
            <form action="{{ route('keterangan.store') }}" method="post" id="keteranganForm">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTambahLabel">Tambah Keterangan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="daftarketerangan">Tambahkan Keterangan</label>
                        <input type="text" class="form-control @error('daftarketerangan') is-invalid @enderror" id="daftarketerangan" 
                        placeholder="Masukan keterangan" name="daftarketerangan" autofocus>
                        @error('daftarketerangan') <span class="text-danger">{{$message}}</span> @enderror
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
@foreach($keterangan as $data)
<!-- Modal Edit -->
<div class="modal fade" id="modalEdit{{ $data->id }}" tabindex="-1" role="dialog" aria-labelledby="modalEditLabel{{ $data->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('keterangan.update', $data->id) }}" method="post">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditLabel{{ $data->id }}">Edit Keterangan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="daftarketerangan">Edit Daftar Keterangan</label>
                        <input type="text" class="form-control" id="daftarketerangan" name="daftarketerangan" value="{{ $data->daftarketerangan }}" required>
                        @error('daftarketerangan') <span class="text-danger">{{$message}}</span> @enderror
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
        });

        $('#modalTambah').on('hidden.bs.modal', function () {
            $('#keteranganForm')[0].reset();
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
