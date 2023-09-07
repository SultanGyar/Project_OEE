@extends('adminlte::page')
@section('title', 'Tambah Target')
@section('content_header')
<h1 class="m-0 text-dark">Tambah Target</h1>

@stop
@section('content')
<form action="{{route('target.store')}}" method="post">
    @csrf
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <label for="target_proses">Nama Proses</label>
                        <select class="form-control @error('target_proses') is-invalid @enderror" id="target_proses" name="target_proses">
                            <option value="" selected disabled>Pilih Proses</option>
                            @foreach ($dataproses as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('target_proses')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    

                    <div class="form-group">
                        <label for="tanggal_target">Tanggal</label>
                        <input type="date" class="form-control @error('tanggal_target') is-invalid @enderror"
                            id="tanggal_target" placeholder="tanggal_target" name="tanggal_target"
                            value="{{ old('tanggal_target') ?? date('Y-m-d') }}">
                        @error('tanggal_target')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="target_quantity_byadmin">Quantity</label>
                        <input type="number" class="form-control @error('target_quantity_byadmin') is-invalid @enderror"
                            id="target_quantity_byadmin" placeholder="Quantity" name="target_quantity_byadmin"
                            value="{{ old('target_quantity_byadmin') }}">
                        @error('target_quantity_byadmin')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{route('target.index')}}" class="btn btn-danger">
                        Batal
                    </a>
                </div>
            </div>
        </div>
    </div>
</form>
@stop
@push('js')
@endpush