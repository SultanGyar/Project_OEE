@extends('adminlte::page')
@section('title', 'List User')
@section('content_header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>User</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">User</li>
            </ol>
        </div>
    </div>
</div>
@stop
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card rounded">
                <div class="card-header bg-gradient-gray-dark">
                    <h3 class="card-title">Daftar Pengguna</h3>
                </div>
                <div class="card-body">
                    <div class="row justify-content-between align-items-center mb-2">
                        <div class="col-md-auto">
                            <a href="{{ route('users.create') }}" class="text-btn-center btn btn-md btn-info" style="height: 38px;">Tambah</a>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered table-stripped" style="width:100%" id="example2">
                            <thead>
                                <tr style="text-align: center; background-color: #069eb5">
                                    <th>Nama Pengguna</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $key => $user)
                                <tr>
                                    <td>{{$user->name}}</td>
                                    <td>{{$user->email}}</td>
                                    <td>{{$user->role}}</td>
                                    <td>
                                        <a href="{{route('users.destroy', $user)}}"
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
@stop
@push('js')

<script>
    $(document).ready(function () {
        var table = $('#example2').DataTable({
            "responsive": true,
            "scrollX": true,
        });
        function notificationBeforeDelete(event, el) {
            event.preventDefault();
            if (confirm('Apakah anda yakin akan menghapus data ? ')) {
                $("#delete-form").attr('action', $(el).attr('href'));
                $("#delete-form").submit();
            }
        }
    });
</script>

<form action="" id="delete-form" method="post">
    @method('delete')
    @csrf
</form>

@endpush
