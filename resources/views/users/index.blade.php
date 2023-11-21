@extends('adminlte::page')
@section('title', 'List User')
<link rel="icon" href="{{ asset('vendor/adminlte/dist/img/icon-title.png') }}" type="image/png">
@section('content_header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Pengguna</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Pengguna</li>
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
                    <h3 class="card-title" style="color: white">Daftar Pengguna</h3>
                </div>
                <div class="card-body">
                    <div style="display: flex; align-items: center;" >
                        <a href="#" class="text-btn-center btn btn-md btn-info mb-2"
                            data-toggle="modal" data-target="#modalTambah">Tambah</a>
                            <button type="button" class="btn btn-success ml-2 mb-2" id="importButton">Import Data</button>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered table-stripped" style="width:100%" id="example2">
                            <thead>
                                <tr style="text-align: center; background-color: #069eb5">
                                    <th>Nama Pengguna</th>
                                    <th>Username</th>
                                    <th>Role</th>
                                    <th>Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $key => $data)
                                <tr>
                                    <td>{{$data->full_name}}</td>
                                    <td>{{$data->name}}</td>
                                    <td>{{$data->role}}</td>
                                    <td>
                                        <a href="#" class="btn btn-info btn-xs" data-toggle="modal"
                                            data-target="#modalEdit{{ $data->id }}">
                                            Edit
                                        </a>
                                        <a href="{{route('users.destroy', $data)}}"
                                            onclick="notificationBeforeDelete(event, this)"
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

<!-- Modal import excel-->
<div class="modal fade" id="modalImport" tabindex="-1" role="dialog" aria-labelledby="modalImportLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('user.import') }}" method="post" enctype="multipart/form-data" id="importForm">
                @csrf
                <div class="modal-header success">
                    <h5 class="modal-title" id="modalImportLabel">Import File</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <div class="input-group">
                            <input type="file" name="file">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <input type="submit" class="btn btn-success" value="Upload">
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="modalTambah" tabindex="-1" role="dialog" aria-labelledby="modalTambahLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('users.store') }}" method="post" id="userForm">
                @csrf
                <input type="hidden" id="validationErrors" name="validationErrors"
                    value="{{ $errors->any() ? 'true' : 'false' }}">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTambahLabel">Tambah Pengguna</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Username<span class="font-weight-normal text-danger">*</label>
                        <input type="text" class="form-control  @error('name') is-invalid @enderror" id="name"
                            placeholder="Masukan Username" name="name">
                        @error('name') <span class="text-danger">{{ $message}}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label for="full_name">Nama Lengkap<span class="font-weight-normal text-danger">*</label>
                        <input type="text" class="form-control  @error('full_name') is-invalid @enderror" id="full_name"
                            placeholder="Masukan Nama Lengkap" name="full_name">
                        @error('full_name') <span class="text-danger">{{ $message}}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label for="password">Kata Sandi<span class="font-weight-normal text-danger">*</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                            id="password" placeholder="Masukan Kata Sandi (min: 5)" name="password" minlength="5"
                            autocomplete="off">
                        @error('password') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label for="password_confirmation">Konfirmasi Kata Sandi<span class="font-weight-normal text-danger">*</label>
                        <input type="password" class="form-control" id="password_confirmation"
                            placeholder="Konfirmasi Kata Sandi (min: 5)" name="password_confirmation" minlength="5"
                            autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="role">Role<span class="font-weight-normal text-danger">*</label>
                        <select class="form-control @error('role') is-invalid @enderror" id="role" name="role">
                            <option disabled selected>Pilih Role</option>
                            <option value="Admin" @if(old('role')=='Admin' )selected @endif>Admin</option>
                            <option value="Operator" @if(old('role')=='Operator' )selected @endif>Operator</option>
                        </select>
                        @error('role') <span class="text-danger">{{$message}}</span> @enderror
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="checkbox" onclick="showingPassword()">
                        <label class="form-check-label" for="checkbox">
                            <span id="checkboxText">Tampilkan</span>
                        <span class="font-weight-normal text-danger">*</label>
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

@foreach($users as $data)
<!-- Modal Edit -->
<div class="modal fade" id="modalEdit{{ $data->id }}" tabindex="-1" role="dialog"
    aria-labelledby="modalEditLabel{{ $data->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('users.update', $data->id) }}" method="post">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditLabel{{ $data->id }}">Edit Pengguna</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="edit_name_{{ $data->id }}">Username<span class="font-weight-normal text-danger">*</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                            id="edit_name_{{ $data->id }}" placeholder="Masukkan Username" name="name"
                            value="{{ $data->name }}">
                        @error('name')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="edit_full_name_{{ $data->id }}">Nama Lengkap<span class="font-weight-normal text-danger">*</label>
                        <input type="text" class="form-control @error('full_name') is-invalid @enderror"
                            id="edit_full_name_{{ $data->id }}" placeholder="Masukkan Nama Lengkap" name="full_name"
                            value="{{ $data->full_name }}">
                        @error('full_name')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="edit_password_{{ $data->id }}">Password<span class="font-weight-normal text-danger">*</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                            id="edit_password_{{ $data->id }}" placeholder="Password" name="password" minlength="5"
                            autocomplete="off">
                        @error('password')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="edit_password_confirmation_{{ $data->id }}">Konfirmasi Password<span class="font-weight-normal text-danger">*</label>
                        <input type="password" class="form-control" id="edit_password_confirmation_{{ $data->id }}"
                            placeholder="Konfirmasi Password" name="password_confirmation" minlength="5"
                            autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="edit_role_{{ $data->id }}">Role<span class="font-weight-normal text-danger">*</label>
                        <select class="form-control @error('role') is-invalid @enderror" id="edit_role_{{ $data->id }}"
                            name="role">
                            <option value="Admin" {{ $data->role === 'Admin' ? 'selected' : '' }}>Admin</option>
                            <option value="Operator" {{ $data->role === 'Operator' ? 'selected' : '' }}>Operator
                            </option>
                        </select>
                        @error('role')
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
        var table = $('#example2').DataTable({
            "responsive": true,
            "scrollX": true,
        });

        $('#modalTambah').on('hidden.bs.modal', function () {
            $('#userForm')[0].reset();
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

        $('#importButton').click(function() {
        $('#modalImport').modal('show');

        });
    });
    


    function showingPassword() {
        var passwordField = document.getElementById("password");
        var passwordConfirmationField = document.getElementById("password_confirmation");
        var checkbox = document.getElementById("checkbox");

        if (checkbox.checked) {
            passwordField.type = "text";
            passwordConfirmationField.type = "text";
            document.getElementById("checkboxText").innerText = "Sembunyikan";
        } else {
            passwordField.type = "password";
            passwordConfirmationField.type = "password";
            document.getElementById("checkboxText").innerText = "Tampilkan";
        }
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