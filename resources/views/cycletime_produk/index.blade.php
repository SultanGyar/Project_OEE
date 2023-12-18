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
                    <div class="d-flex flex-wrap justify-content-between align-items-center mb-2">
                        <div class="d-flex align-items-center">
                            <a href="#" class="text-btn-center btn btn-md btn-info mb-2 mr-2" data-toggle="modal" data-target="#modalTambah">
                                Tambah
                            </a>
                            <button type="button" class="btn btn-success mb-2" id="importButton">Import Data</button>
                        </div>
                        @can('admin-only')
                        <div class="inline">
                            <button type="button" class="btn btn-secondary mr-1 mb-2 d-inline" id="cetakQrButton">Cetak QR</button>
                        </div>
                        
                        @endcan
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered table-striped" style="width: 100%" id="example2">
                            <thead>
                                <tr style="text-align: center; background-color: #069eb5;">
                                    <th>Proses</th>
                                    <th>Size</th>
                                    <th>Class</th>
                                    <th>Kapasitas <br>/Pcs</th>
                                    <th>Kode</th>
                                    <th>QR</th>
                                    <th>Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($produk as $data)
                                <tr>
                                    <td class="text-center">{{ $data->daftarproses }}</td>
                                    <td class="text-center">{{ $data->size }}</td>
                                    <td class="text-center">{{ $data->class }}</td>
                                    <td class="text-center">{{ $data->kapasitas_pcs }}</td>
                                    <td class="text-center">{{ $data->kode }}</td>
                                    <td class="text-center">
                                        {!! $data->qr
                                            ? '<img id="qrCode_' . $data->id . '" src="data:image/svg+xml;base64,'.base64_encode($data->qr).'" alt="QR Code" class="btn-pratinjau-qr" data-toggle="modal" data-target="#modalPratinjauQR">'
                                            : 'No QR Code'
                                        !!}
                                    </td>                               
                                    <td class="text-center">
                                        <a href="#" class="btn btn-info btn-xs" data-toggle="modal" data-target="#modalEdit{{ $data->id }}">
                                            Edit
                                        </a>
                                        <a href="{{ route('cycletime_produk.cetak', ['daftarproses' => $data->daftarproses]) }}" class="btn btn-secondary btn-xs" target="_blank">
                                            Cetak
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

<!-- Modal Pratinjau QR Code -->
<div class="modal fade" id="modalPratinjauQR" tabindex="-1" role="dialog" aria-labelledby="modalPratinjauQRLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <img id="imgPratinjauQR" src="" alt="QR Code" class="img-fluid qr-img">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal import excel-->
<div class="modal fade" id="modalImport" tabindex="-1" role="dialog" aria-labelledby="modalImportLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('cycletime.import') }}" method="post" enctype="multipart/form-data" id="importForm">
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
                        <label for="daftarproses">Nama Proses<span class="font-weight-normal text-danger">*</label>
                        <select class="form-control @error('daftarproses') is-invalid @enderror" id="daftarproses"
                            name="daftarproses">
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
                        <label for="size">Size<span class="font-weight-normal text-danger">*</label>
                        <input type="string" class="form-control @error('size') is-invalid @enderror" id="size"
                            placeholder="Size" name="size" value="{{ old('size') }}">
                        @error('size')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="class">Class<span class="font-weight-normal text-danger">*</label>
                        <input type="string" class="form-control @error('class') is-invalid @enderror" id="class"
                            placeholder="Class" name="class" value="{{ old('class') }}">
                        @error('class')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="kapasitas_pcs">Kapasitas/Pcs<span class="font-weight-normal text-danger">*</label>
                        <input type="number" class="form-control @error('kapasitas_pcs') is-invalid @enderror"
                            id="kapasitas_pcs" placeholder="Kapasitas/Pcs" name="kapasitas_pcs"
                            value="{{ old('kapasitas_pcs') }}">
                        @error('kapasitas_pcs')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="kode">Kode<span class="font-weight-normal text-danger">*</label>
                        <input type="string" class="form-control @error('kode') is-invalid @enderror" id="kode"
                            placeholder="Kode" name="kode" value="{{ old('kode') }}">
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
<div class="modal fade" id="modalEdit{{ $data->id }}" tabindex="-1" role="dialog"
    aria-labelledby="modalEditLabel{{ $data->id }}" aria-hidden="true">
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
                        <label for="daftarproses{{ $data->id }}">Nama Proses<span class="font-weight-normal text-danger">*</label>
                        <select class="form-control @error('daftarproses') is-invalid @enderror"
                            id="daftarproses{{ $data->id }}" name="daftarproses">
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
                        <label for="size{{ $data->id }}">Size<span class="font-weight-normal text-danger">*</label>
                        <input type="text" class="form-control @error('size') is-invalid @enderror" id="size{{ $data->id }}" 
                        placeholder="Size" name="size" value="{{$data->size ?? old('size') }}">
                        @error('size')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="class{{ $data->id }}">Class<span class="font-weight-normal text-danger">*</label>
                        <input type="string" class="form-control @error('class') is-invalid @enderror"
                            id="class{{ $data->id }}" placeholder="Class" name="class"
                            value="{{$data->class ?? old('class') }}">
                        @error('class')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="kapasitas_pcs{{ $data->id }}">Kapasitas/Pcs<span class="font-weight-normal text-danger">*</label>
                        <input type="number" class="form-control @error('kapasitas_pcs') is-invalid @enderror" id="kapasitas_pcs{{ $data->id }}" 
                        placeholder="Kapasitas/Pcs" name="kapasitas_pcs" value="{{$data->kapasitas_pcs ?? old('kapasitas_pcs') }}">

                        @error('kapasitas_pcs')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="kode{{ $data->id }}">Kode<span class="font-weight-normal text-danger">*</label>
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

<style>
    .qr-img {
        width: 50%;
        max-height: 80vh;
        margin: auto;
        display: block;
    }
</style>

@stop
@push('js')
<script>
    $(document).ready(function () {
        // Fungsi untuk menangani pratinjau QR Code
        function handleQRPreview(src) {
            $('#imgPratinjauQR').attr('src', src);
            $('#modalPratinjauQR').modal('show');
        }

        $('.btn-pratinjau-qr').click(function () {
            // Ambil ID produk dari ID QR Code
            var productId = $(this).attr('id').replace('qrCode_', '');

            // Ambil sumber gambar QR Code
            var qrCodeSrc = $(this).attr('src');

            // Tampilkan modal pratinjau QR Code
            handleQRPreview(qrCodeSrc);
        });


        $('#modalTambah').on('hidden.bs.modal', function () {
            $('#produkForm')[0].reset();
            $('.is-invalid').removeClass('is-invalid');
            $('.text-danger').remove();
        });

        $('#cetakQrButton').click(function () {
            $('#cetakQrModal').modal('show');
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

        // Fungsi untuk membuka modal preview QR code
        function openQRModal(id) {
            var modalId = '#qrModal' + id;
            $(modalId).modal('show');
        }

        // Memanggil fungsi openQRModal saat tombol "Lihat QR Code" ditekan
        $('.btn-qr-preview').click(function () {
            var id = $(this).data('id');
            openQRModal(id);
        });

        $('#importButton').click(function() {
            $('#modalImport').modal('show');
        });

        $('.btn-pratinjau-qr').click(function () {
            var src = $(this).attr('src');
            $('#imgPratinjauQR').attr('src', src);
        });
    });

</script>
@endpush
