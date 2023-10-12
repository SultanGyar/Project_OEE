@extends('adminlte::page')
@section('title', 'Cycle Time Produk')
<link rel="icon" href="{{ asset('vendor/adminlte/dist/img/icon-title.png') }}" type="image/png">
@section('content_header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Cycle Time Produk</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Cycle Time Produk</li>
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
                    <h3 class="card-title" style="color: white">Cycle Time Produk</h3>
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
                                    <th>Proses</th>
                                    <th>Size</th>
                                    <th>Class</th>
                                    <th>Kapasitas/Pcs</th>
                                    <th>Kode</th>
                                    <th>Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($produk as $data)

                                <tr>
                                    <td>{{ $data->daftarproses }}</td>
                                    <td>{{ $data->size }}</td>
                                    <td>{{ $data->class }}</td>
                                    <td>{{ $data->kapasitas_pcs }}</td>
                                    <td>{{ $data->kode }}</td>
                                    <td>
                                        <a href="#" class="btn btn-info btn-xs" data-toggle="modal" data-target="#modalEdit{{ $data->id }}">
                                            Edit
                                        </a>
                                        <a href="{{ route('cycletime_produk.destroy', $data) }}"
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
<div class="modal fade" id="modalTambah" tabindex="-1" role="dialog" aria-labelledby="modalTambahLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('cycletime_produk.store') }}" method="post" id="produkForm">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTambahLabel">Tambah Produk</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="daftarproses">Nama Proses</label>
                        <select class="form-control @error('daftarproses') is-invalid @enderror" id="daftarproses" name="daftarproses">
                            <option value="" selected disabled>Pilih Proses</option>
                            @foreach ($dataproses as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('daftarproses')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="size">Size</label>
                        <input type="string" class="form-control @error('size') is-invalid @enderror"
                            id="size" placeholder="Size" name="size"
                            value="{{ old('size') }}">
                        @error('size')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="class">Class</label>
                        <input type="string" class="form-control @error('class') is-invalid @enderror"
                            id="class" placeholder="Class" name="class"
                            value="{{ old('class') }}">
                        @error('class')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="kapasitas_pcs">Kapasitas/Pcs</label>
                        <input type="number" class="form-control @error('kapasitas_pcs') is-invalid @enderror"
                            id="kapasitas_pcs" placeholder="Kapasitas/Pcs" name="kapasitas_pcs"
                            value="{{ old('kapasitas_pcs') }}">
                        @error('kapasitas_pcs')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="kode">Kode</label>
                        <input type="string" class="form-control @error('kode') is-invalid @enderror"
                            id="kode" placeholder="Kode" name="kode"
                            value="{{ old('kode') }}">
                        @error('kode')
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

<!-- Modal Edit -->
@foreach($produk as $data)
<div class="modal fade" id="modalEdit{{ $data->id }}" tabindex="-1" role="dialog" aria-labelledby="modalEditLabel{{ $data->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('cycletime_produk.update', $data->id) }}" method="post">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditLabel{{ $data->id }}">Edit Produk</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="daftarproses{{ $data->id }}">Nama Proses</label>
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
                        <label for="size{{ $data->id }}">Size</label>
                        <input type="string" class="form-control @error('size') is-invalid @enderror"
                            id="size{{ $data->id }}" placeholder="Size" name="size"
                            value="{{$data->size ?? old('size') }}">
                        @error('size')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>   

                    <div class="form-group">
                        <label for="class{{ $data->id }}">Class</label>
                        <input type="string" class="form-control @error('class') is-invalid @enderror"
                            id="class{{ $data->id }}" placeholder="Class" name="class"
                            value="{{$data->class ?? old('class') }}">
                        @error('class')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="kapasitas_pcs{{ $data->id }}">Kapasitas/Pcs</label>
                        <input type="integer" class="form-control @error('kapasitas_pcs') is-invalid @enderror"
                            id="kapasitas_pcs{{ $data->id }}" placeholder="Kapasitas/Pcs" name="kapasitas_pcs"
                            value="{{$data->kapasitas_pcs ?? old('kapasitas_pcs') }}">
                        @error('kapasitas_pcs')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>   
                    <div class="form-group">
                        <label for="kode{{ $data->id }}">Kode</label>
                        <input type="string" class="form-control @error('kode') is-invalid @enderror"
                            id="kode{{ $data->id }}" placeholder="Kode" name="kode"
                            value="{{$data->kode ?? old('kode') }}">
                        @error('kode')
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
        });

        $('#modalTambah').on('hidden.bs.modal', function () {
            $('#produkForm')[0].reset();
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
