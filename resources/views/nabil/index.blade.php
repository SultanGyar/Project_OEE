@extends('adminlte::page')
@section('title', 'List Detail Pembelian')
@section('content_header')
<h1 class="m-0 text-dark">List Detail Pembelian</h1>
@stop
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                @can('pemilik-only')
                <a href="/exportpdf" class="btn btn-info mb-2">
                    Export Pdf
                </a>
                @endcan
                @can('gudang-only')
                <a href="{{route('detail_pembelian.create')}}" class="btn btn-primary mb-2">Tambah
                </a>
                @endcan
                <table class="table table-hover table-bordered table-stripped" id="example2">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama Obat</th>
                            <th>Harga Beli</th>
                            <th>Jumlah Beli</th>
                            <th>Persen Margin Jual</th>
                            <th>Sub Total Beli</th>
                            <th>No. Pembelian</th>
                            <th>Tanggal Kadaluarsa</th>
                            @can('gudang-only')<th>Opsi</th>@endcan
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($detail_pembelian as $key => $sk)
                        <tr>
                            <td>{{$key+1}}</td>
                            <td>{{$sk->fobat->nama_obat}}</td>
                            <td>{{$sk->harga_beli}}</td>
                            <td>{{$sk->jumlah_beli}}</td>
                            <td>{{$sk->persen_margin_jual}}</td>
                            <td>{{$sk->sub_total_beli}}</td>
                            <td>{{$sk->fpembelian->nonota_beli}}</td>
                            <td>{{$sk->tgl_kadarluarsa}}</td>
                            @can('gudang-only')
                            <td>
                                <a href="{{route('detail_pembelian.edit', $sk)}}" class="btn btn-primary btn-xs">
                                    Edit
                                </a>
                                <a href="{{route('detail_pembelian.destroy', $sk)}}"
                                    onclick="notificationBeforeDelete(event, this, <?php echo $key+1; ?>)"
                                    class="btn btn-danger btn-xs">
                                    Delete
                                </a>
                            </td>
                            @endcan
                        </tr>
                        @endforeach
                    </tbody>
                </table>
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

function notificationBeforeDelete(event, el, dt) {
    event.preventDefault();
    if (confirm('Apakah anda yakin akan menghapus data detail pembelian ?')) {
        $("#delete-form").attr('action', $(el).attr('href'));
        $("#delete-form").submit();
    }
}
</script>
@endpush