@extends('adminlte::page')
@section('title', 'Edit Data')

@section('content_header')
<h1 class="m-0 text-dark">Edit Data Target</h1>
@stop
@section('content')
<form action="{{route('target.update', $target)}}" method="post">
    @method('PUT')
    @csrf
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <label for="target_proses"> Nama Proses </label>
                        <select class="form-control @error('target_proses') is-invalid @enderror" id="target_proses"
                            name="target_proses">
                            <option value="" hidden>Pilih Proses</option>
                            <option value="Winding" @if($target->target_proses == 'Winding' || old('target_proses')=='Winding' ) selected @endif>Winding</option>
                            <option value="Power Press" @if($target->target_proses == 'Power Press' || old('target_proses')=='Power Press' ) selected @endif>Power Press</option>
                            <option value="Assembling" @if($target->target_proses == 'Assembling' || old('target_proses')=='Assembling' ) selected @endif>Assembling</option>
                        </select>
                        @error('target_proses')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="tanggal_target">Tanggal</label>
                        <input type="date" class="form-control @error('tanggal_target') is-invalid @enderror"
                            id="tanggal_target" placeholder="tanggal_target" name="tanggal_target"
                            value="{{$target->tanggal_target ?? old('tanggal_target') ?? date('Y-m-d') }}">
                        @error('tanggal_target')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="target_quantity_byadmin">Target Quantity</label>
                        <input type="number" class="form-control @error('target_quantity_byadmin') is-invalid @enderror"
                            id="target_quantity_byadmin" placeholder="Quantity" name="target_quantity_byadmin"
                            value="{{$target->target_quantity_byadmin ?? old('target_quantity_byadmin') }}">
                        @error('target_quantity_byadmin')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>                    
            
                </div>
                <div class="card-footer">
                    @if($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
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