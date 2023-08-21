@extends('adminlte::page')
@section('title', 'List User')
@section('content_header')
<h1 class="m-0 text-dark">List User</h1>

@stop
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="card-header">
                    <h4 class="card-title-center text-center text-dark">Daftar Pengguna</h4>
                </div>
                <p></p>
                <a href="{{route('users.create')}}" class="btn btn-sm btn-primary mb-2">
                    Tambah
                </a>
                <div class="table-responsive">
                    <table class="table table-hover table-bordered table-stripped" id="example2">
                        <thead>
                            <tr style="text-align: center; background-color: #7b91bc">
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
</script>
@endpush