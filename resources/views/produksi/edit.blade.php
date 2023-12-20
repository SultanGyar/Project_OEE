@extends('adminlte::page')
@section('title', 'Edit Data Produksi')
<link rel="icon" href="{{ asset('vendor/adminlte/dist/img/icon-title.png') }}" type="image/png">
@section('content_header')
<h1 class="m-0 text-dark">Edit Data Produksi</h1>
@stop
@section('content')
<form action="{{ route('produksi.update', $produksi) }}" method="post">
    @method('PUT')
    @csrf
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <label for="nama_user">Nama Operator<span class="font-weight-normal text-danger">*</label>
                        <div class="input-group">
                            <input type="hidden" name="nama_user" id="nama_user">
                            <input type="text" class="form-control @error('nama_user') is-invalid @enderror"
                                placeholder="Nama Operator" id="nama_user" name="nama_user"
                                value="{{ $produksi->nama_user ?? old('nama_user') }}" aria-describedby="cari" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="tanggal">Tanggal<span class="font-weight-normal text-danger">*</label>
                        <input type="date" class="form-control @error('tanggal') is-invalid @enderror" id="tanggal"
                            placeholder="Tanggal" name="tanggal" value="{{ $produksi->tanggal ?? old('tanggal') }}">
                        @error('tanggal')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="daftarproses">Proses <span class="font-weight-normal text-danger">*</label>
                        <input type="text" class="form-control @error('daftarproses') is-invalid @enderror"
                            id="daftarproses" placeholder="(otomatis)" name="daftarproses"
                            value="{{ $produksi->daftarproses ?? old('daftarproses') }}" readonly>
                        @error('daftarproses')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="daftarkelompok">Kelompok <span class="font-weight-normal text-danger">*</label>
                        <input type="text" class="form-control @error('daftarkelompok') is-invalid @enderror"
                            id="daftarkelompok" placeholder="(otomatis)" name="daftarkelompok"
                            value="{{ $produksi->daftarkelompok ?? old('daftarkelompok') }}" readonly>
                        @error('daftarkelompok')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="kapasitas_pcs">Kapasitas/Pcs <span
                                class="font-weight-normal">(Otomatis)</span><span class="font-weight-normal text-danger">*</label>
                        <input type="number" class="form-control @error('kapasitas_pcs') is-invalid @enderror"
                            id="kapasitas_pcs" placeholder="(otomatis)" name="kapasitas_pcs"
                            value="{{ $produksi->kapasitas_pcs ?? old('kapasitas_pcs') }}" readonly>
                        @error('kapasitas_pcs')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="produk_size">Size <span class="font-weight-normal text-danger">*</label>
                        <input type="text" class="form-control @error('produk_size') is-invalid @enderror"
                            id="produk_size" placeholder="(otomatis)" name="produk_size"
                            value="{{ $produksi->produk_size ?? old('produk_size') }}" readonly>
                        @error('produk_size')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="produk_class">Class <span class="font-weight-normal text-danger">*</label>
                        <input type="text" class="form-control @error('produk_class') is-invalid @enderror"
                            id="produk_class" placeholder="(otomatis)" name="produk_class"
                            value="{{ $produksi->produk_class ?? old('produk_class') }}" readonly>
                        @error('produk_class')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="target_quantity">Target Quantity <span
                                class="font-weight-normal">(Otomatis)</span><span class="font-weight-normal text-danger">*</label>
                        <input type="number" class="form-control @error('target_quantity') is-invalid @enderror"
                            id="target_quantity" placeholder="(otomatis)" name="target_quantity"
                            value="{{ $produksi->target_quantity ?? old('target_quantity') }}" readonly>
                        @error('target_quantity')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="kode">Kode<span class="font-weight-normal text-danger">*</label>
                        <select class="form-control mb-10 @error('kode') is-invalid @enderror" id="kode" name="kode"
                            style="width: 100%">
                            <option value="" selected disabled>Pilih Kode..</option>
                            @foreach ($datakode as $value => $label)
                            <option value="{{ $value }}" @if ($value==$produksi->kode || old('kode') == $value) selected
                                @endif>{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('kode')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="quantity">Actual Quantity<span class="font-weight-normal text-danger">*</label>
                        <input type="number" class="form-control @error('quantity') is-invalid @enderror" id="quantity"
                            placeholder="Actual Quantity" name="quantity"
                            value="{{ $produksi->quantity ?? old('quantity') }}">
                        @error('quantity')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group" hidden>
                        <label for="finish_good">Good Quality<span class="font-weight-normal text-danger">*</label>
                        <input type="number" class="form-control @error('finish_good') is-invalid @enderror"
                            id="finish_good" placeholder="Good Quality" name="finish_good"
                            value="{{ $produksi->finish_good ?? old('finish_good') }}">
                        @error('finish_good')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="reject">Not Good</label>
                        <input type="number" class="form-control @error('reject') is-invalid @enderror" id="reject"
                            Reject="reject" placeholder="Not Good" name="reject"
                            value="{{ $produksi->reject ?? old('reject') }}">
                        @error('reject')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="daftarketerangan">Keterangan Not Good</label>
                        <select class="form-control mb-10 @error('daftarketerangan') is-invalid @enderror"
                            id="daftarketerangan" name="daftarketerangan" style="width: 100%">
                            <option value="">Tidak ada</option>
                            @foreach ($dataketerangan as $value => $label)
                            <option value="{{ $value }}" @if ($value==$produksi->daftarketerangan ||
                                old('daftarketerangan') == $value) selected @endif>{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('daftarketerangan')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 border">
                            <div class="form-group">
                                <label for="operating_start_time">Operating Start<span class="font-weight-normal text-danger">*</label>
                                <input type="time"
                                    class="form-control @error('operating_start_time') is-invalid @enderror"
                                    id="operating_start_time" placeholder="" name="operating_start_time"
                                    value="{{ $produksi->operating_start_time ?? old('operating_start_time') }}" />
                                @error('operating_start_time')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6 border">
                            <div class="form-group">
                                <label for="operating_end_time">Operating End<span class="font-weight-normal text-danger">*</label>
                                <input type="time"
                                    class="form-control @error('operating_end_time') is-invalid @enderror"
                                    id="operating_end_time" placeholder="" name="operating_end_time"
                                    value="{{ $produksi->operating_end_time ?? old('operating_end_time') }}">
                                @error('operating_end_time')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="operating_time">Operating Time<span class="font-weight-normal text-danger">*</label>
                        <input type="time" class="form-control @error('operating_time') is-invalid @enderror"
                            id="operating_time" placeholder="Operating Time" name="operating_time"
                            value="{{ $produksi->operating_time ?? old('operating_time') }}" readonly>
                        @error('operating_time')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="dropdown">
                        <button class="btn btn-info dropdown-toggle" type="button" id="toggleForm"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Pilih Kategori Down Time
                        </button>
                        <div class="dropdown-menu" aria-labelledby="toggleForm">
                            <!-- Checkbox untuk menyembunyikan atau menampilkan form input -->
                            <div class="dropdown-item">
                                <input class="form-check-input hide-checkbox" type="checkbox" id="hideFormA" data-target="formA" @if(isset($produksi) && $produksi->a_time) checked @endif>
                                <label class="form-check-label" for="hideFormA">Kategori A (GANTI ORDER)</label>
                            </div>
                            <div class="dropdown-item">
                                <input class="form-check-input hide-checkbox" type="checkbox" id="hideFormB" data-target="formB" @if(isset($produksi) && $produksi->b_time) checked @endif>
                                <label class="form-check-label" for="hideFormB">Kategori B (PERBAIKAN)</label>
                            </div>
                            
                            <div class="dropdown-item">
                                <input class="form-check-input hide-checkbox" type="checkbox" id="hideFormC" data-target="formC" @if(isset($produksi) && $produksi->c_time) checked @endif>
                                <label class="form-check-label" for="hideFormC">Kategori C (MENUNGGU MATERIAL)</label>
                            </div>
                            
                            <div class="dropdown-item">
                                <input class="form-check-input hide-checkbox" type="checkbox" id="hideFormD" data-target="formD" @if(isset($produksi) && $produksi->d_time) checked @endif>
                                <label class="form-check-label" for="hideFormD">Kategori D (OPERATOR)</label>
                            </div>
                            
                            <div class="dropdown-item">
                                <input class="form-check-input hide-checkbox" type="checkbox" id="hideFormE" data-target="formE" @if(isset($produksi) && $produksi->e_time) checked @endif>
                                <label class="form-check-label" for="hideFormE">Kategori E (MAINTENANCE)</label>
                            </div>
                            
                            <div class="dropdown-item">
                                <input class="form-check-input hide-checkbox" type="checkbox" id="hideFormF" data-target="formF" @if(isset($produksi) && $produksi->f_time) checked @endif>
                                <label class="form-check-label" for="hideFormF">Kategori F (PEMERIKSAAN)</label>
                            </div>
                            
                            <div class="dropdown-item">
                                <input class="form-check-input hide-checkbox" type="checkbox" id="hideFormG" data-target="formG" @if(isset($produksi) && $produksi->g_time) checked @endif>
                                <label class="form-check-label" for="hideFormG">Kategori G (REJECT)</label>
                            </div>
                            
                            <div class="dropdown-item">
                                <input class="form-check-input hide-checkbox" type="checkbox" id="hideFormH" data-target="formH" @if(isset($produksi) && $produksi->h_time) checked @endif>
                                <label class="form-check-label" for="hideFormH">Kategori H (REWORK)</label>
                            </div>                            
                        </div>
                    </div>

                    <div id="formA" style="display: none;">
                        <div class="form-group">
                            <label for="a_time">Total Waktu Kategori A</label>
                            <input type="number" class="form-control @error('a_time') is-invalid @enderror" id="a_time"
                                placeholder="A Time" name="a_time" value="{{ $produksi->a_time ?? old('a_time') }}">
                        </div>
                    </div>

                    <div id="formB" style="display: none;">
                        <div class="form-group">
                            <label for="b_time">Total Waktu Kategori B</label>
                            <input type="number" class="form-control @error('b_time') is-invalid @enderror" id="b_time"
                                placeholder="B Time" name="b_time" value="{{ $produksi->b_time ?? old('b_time') }}">
                        </div>
                    </div>

                    <div id="formC" style="display: none;">
                        <div class="form-group">
                            <label for="c_time">Total Waktu Kategori C</label>
                            <input type="number" class="form-control @error('c_time') is-invalid @enderror" id="c_time"
                                placeholder="C Time" name="c_time" value="{{ $produksi->c_time ?? old('c_time') }}">
                        </div>
                    </div>

                    <div id="formD" style="display: none;">
                        <div class="form-group">
                            <label for="d_time">Total Waktu Kategori D</label>
                            <input type="number" class="form-control @error('d_time') is-invalid @enderror" id="d_time"
                                placeholder="D Time" name="d_time" value="{{ $produksi->d_time ?? old('d_time') }}">
                        </div>
                    </div>

                    <div id="formE" style="display: none;">
                        <div class="form-group">
                            <label for="e_time">Total Waktu Kategori E</label>
                            <input type="number" class="form-control @error('e_time') is-invalid @enderror" id="e_time"
                                placeholder="E Time" name="e_time" value="{{ $produksi->e_time ?? old('e_time') }}">
                        </div>
                    </div>

                    <div id="formF" style="display: none;">
                        <div class="form-group">
                            <label for="f_time">Total Waktu Kategori F</label>
                            <input type="number" class="form-control @error('f_time') is-invalid @enderror" id="f_time"
                                placeholder="F Time" name="f_time" value="{{ $produksi->f_time ?? old('f_time') }}">
                        </div>
                    </div>

                    <div id="formG" style="display: none;">
                        <div class="form-group">
                            <label for="g_time">Total Waktu Kategori G</label>
                            <input type="number" class="form-control @error('g_time') is-invalid @enderror" id="g_time"
                                placeholder="G Time" name="g_time" value="{{ $produksi->g_time ?? old('g_time') }}">
                        </div>
                    </div>

                    <div id="formH" style="display: none;">
                        <div class="form-group">
                            <label for="h_time">Total Waktu Kategori H</label>
                            <input type="number" class="form-control @error('h_time') is-invalid @enderror" id="h_time"
                                placeholder="H Time" name="h_time" value="{{ $produksi->h_time ?? old('h_time') }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="down_time">Actual Down Time<span class="font-weight-normal text-danger">*</label>
                        <input type="time" class="form-control @error('down_time') is-invalid @enderror" id="down_time"
                            placeholder="Down Time" name="down_time"
                            value="{{ $produksi->down_time ?? old('down_time') }}" readonly>
                    </div>

                    <div class="form-group">
                        <label for="actual_time">Actual Time<span class="font-weight-normal text-danger">*</label>
                        <input type="time" class="form-control @error('actual_time') is-invalid @enderror"
                            id="actual_time" placeholder="Actual Time" name="actual_time"
                            value="{{ $produksi->actual_time ?? old('actual_time') }}" readonly>
                        @error('actual_time')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-info">Simpan</button>
                        <a href="{{ route('produksi.index') }}" class="btn btn-danger">Batal</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

<script>

    // Fungsi bantuan untuk mengonversi durasi dalam format "HH:mm:ss" menjadi menit
    function parseDuration(duration) {
        const [hours, minutes] = duration.split(':').map(Number);
        return (hours * 60) + minutes;
    }

    // Fungsi untuk menghitung actual_time sebagai selisih dari operating_time dan b_time dalam menit
    function calculateActualTime() {
        const operating_timeInput = document.getElementById('operating_time');
        const b_timeInput = document.getElementById('b_time');
        const actual_timeInput = document.getElementById('actual_time');
        const kapasitasPcsInput = document.getElementById('kapasitas_pcs');

        const operating_time = parseDuration(operating_timeInput.value);
        const b_time = b_timeInput.value;
        
        // Hitung actual_time dalam menit
        const actualTimeInMinutes = operating_time - b_time;

        // Ubah durasi menjadi format jam dan menit (HH:mm) dan perbarui nilai pada input actual_time
        const formattedDuration = `${Math.floor(actualTimeInMinutes / 60).toString().padStart(2, '0')}:${(actualTimeInMinutes % 60).toString().padStart(2, '0')}`;
        actual_timeInput.value = formattedDuration;

        // Hitung actual_time dalam detik
        const actualTimeInSeconds = actualTimeInMinutes * 60;

        // Ambil nilai kapasitas_pcs
        const kapasitasPcs = parseFloat(kapasitasPcsInput.value) || 0;

        // Hitung target_quantity dan isi nilai ke form target_quantity
        const targetQuantity = actualTimeInSeconds / kapasitasPcs;
        document.getElementById('target_quantity').value = Math.round(targetQuantity); // Bulatkan ke bilangan bulat terdekat
    }

    

    $(document).ready(function() {
        $('form').submit(function () {
            // Check if the down_time field is empty
            if ($('#down_time').val() === '') {
                // Set the value to "00:00:00"
                $('#down_time').val('00:00:00');
            }
        });

         // Panggil fungsi getDataAuto saat halaman dimuat
         getDataAuto();

        // Panggil fungsi getDataAuto juga saat nilai 'kode' berubah
        $('#kode').on('change', function() {
            getDataAuto();
        });
    });

    function getDataAuto() {
        var selectedKode = $('#kode').val();
        
        // Langkah 1: Isi daftarproses dan kapasitas_pcs
        $.ajax({
            url: '/get-data-auto',
            method: 'GET',
            data: {
                kode: selectedKode,
            },
            success: function(response) {

                if (response.success) {
                    var daftarproses = response.daftarproses;
                    var kapasitasPcs = response.kapasitas_pcs;
                    var produk_size = response.produk_size;
                    var produk_class = response.produk_class;

                    $('#daftarproses').val(daftarproses);
                    $('#kapasitas_pcs').val(kapasitasPcs);
                    $('#produk_size').val(produk_size);
                    $('#produk_class').val(produk_class);

                    // Langkah 2: Periksa kesamaan dengan AnggotaKelompok
                    if (response.daftarkelompok) {
                        $('#daftarkelompok').val(response.daftarkelompok);
                    } else {
                        // Jika tidak ada kesamaan, Anda dapat melakukan tindakan lain
                    }

                    calculateActualTime();
                }
            },
            error: function() {
                console.log('Error: Failed to make the request.');
            }
        });
    }

    // Panggil fungsi getDataAuto saat nilai 'kode' berubah
    $('#kode').on('change', function() {
        getDataAuto();
    });


    document.getElementById('quantity').addEventListener('input', function () {
        calculateGoodQuality();
    });
    document.getElementById('reject').addEventListener('input', function () {
        calculateGoodQuality();
    });
    function calculateGoodQuality() {
        var quantity = parseFloat(document.getElementById('quantity').value) || 0;
        var reject = parseFloat(document.getElementById('reject').value) || 0;
        var goodQuality = quantity - reject;
        goodQuality = goodQuality < 0 ? 0 : goodQuality;
        document.getElementById('finish_good').value = goodQuality;
    }


    // Button Show and Hide
    // Ambil elemen-elemen yang diperlukan
    const formA = document.getElementById('formA');
    const formB = document.getElementById('formB');
    const formC = document.getElementById('formC');
    const formD = document.getElementById('formD');
    const formE = document.getElementById('formE');
    const formF = document.getElementById('formF');
    const formG = document.getElementById('formG');
    const formH = document.getElementById('formH');
    const hideFormCheckboxA = document.getElementById('hideFormA');
    const hideFormCheckboxB = document.getElementById('hideFormB');
    const hideFormCheckboxC = document.getElementById('hideFormC');
    const hideFormCheckboxD = document.getElementById('hideFormD');
    const hideFormCheckboxE = document.getElementById('hideFormE');
    const hideFormCheckboxF = document.getElementById('hideFormF');
    const hideFormCheckboxG = document.getElementById('hideFormG');
    const hideFormCheckboxH = document.getElementById('hideFormH');
  
    // Fungsi untuk menampilkan atau menyembunyikan form input berdasarkan checkbox
    function toggleForm() {
      formA.style.display = hideFormCheckboxA.checked ? 'block' : 'none';
      formB.style.display = hideFormCheckboxB.checked ? 'block' : 'none';
      formC.style.display = hideFormCheckboxC.checked ? 'block' : 'none';
      formD.style.display = hideFormCheckboxD.checked ? 'block' : 'none';
      formE.style.display = hideFormCheckboxE.checked ? 'block' : 'none';
      formF.style.display = hideFormCheckboxF.checked ? 'block' : 'none';
      formG.style.display = hideFormCheckboxG.checked ? 'block' : 'none';
      formH.style.display = hideFormCheckboxH.checked ? 'block' : 'none';
    }
  
    // Panggil fungsi saat checkbox diubah
    hideFormCheckboxA.addEventListener('change', toggleForm);
    hideFormCheckboxB.addEventListener('change', toggleForm);
    hideFormCheckboxC.addEventListener('change', toggleForm);
    hideFormCheckboxD.addEventListener('change', toggleForm);
    hideFormCheckboxE.addEventListener('change', toggleForm);
    hideFormCheckboxF.addEventListener('change', toggleForm);
    hideFormCheckboxG.addEventListener('change', toggleForm);
    hideFormCheckboxH.addEventListener('change', toggleForm);


    function toggleForm() {
    const hideFormCheckboxes = document.querySelectorAll('.hide-checkbox');
    
    hideFormCheckboxes.forEach(checkbox => {
        const formId = checkbox.getAttribute('data-target');
        const form = document.getElementById(formId);

        if (checkbox.checked) {
        form.style.display = 'block';
        } else {
        form.style.display = 'none';
        }
    });
    }

    // Panggil fungsi untuk mengatur tampilan awal halaman
    toggleForm();
  
    // Panggil fu

     // Fungsi untuk menghitung total waktu dari Form A hingga Form H
    function calculateDownTime() {
        // Mengambil nilai waktu dari Form A hingga H
        var aTimeValue = parseInt(document.getElementById('a_time').value) || 0;
        var bTimeValue = parseInt(document.getElementById('b_time').value) || 0;
        var cTimeValue = parseInt(document.getElementById('c_time').value) || 0;
        var dTimeValue = parseInt(document.getElementById('d_time').value) || 0;
        var eTimeValue = parseInt(document.getElementById('e_time').value) || 0;
        var fTimeValue = parseInt(document.getElementById('f_time').value) || 0;
        var gTimeValue = parseInt(document.getElementById('g_time').value) || 0;
        var hTimeValue = parseInt(document.getElementById('h_time').value) || 0;

        // Menghitung total waktu dari Form A hingga H
        var totalTime = aTimeValue + bTimeValue + cTimeValue + dTimeValue + eTimeValue + fTimeValue + gTimeValue + hTimeValue;

        // Memastikan bahwa setidaknya satu nilai dari Form A hingga H tidak sama dengan nilai default atau kosong
        var isAnyValueSet = aTimeValue !== 0 || bTimeValue !== 0 || cTimeValue !== 0 || dTimeValue !== 0 || eTimeValue !== 0 || fTimeValue !== 0 || gTimeValue !== 0 || hTimeValue !== 0;

        // Jika setidaknya satu nilai tidak sama dengan nilai default atau kosong
        if (isAnyValueSet) {
            // Memastikan bahwa total waktu adalah angka positif
            if (!isNaN(totalTime) && totalTime >= 0) {
                // Menghitung waktu dalam format 'hh:mm' berdasarkan total waktu
                var hours = Math.floor(totalTime / 60);
                var minutes = totalTime % 60;

                // Menetapkan nilai yang dihitung ke input Down Time
                document.getElementById('down_time').value = ('0' + hours).slice(-2) + ':' + ('0' + minutes).slice(-2);
            }
        }
    }

    // Menghubungkan event listener ke semua Form A hingga Form H
    document.getElementById('a_time').addEventListener('input', calculateDownTime);
    document.getElementById('b_time').addEventListener('input', calculateDownTime);
    document.getElementById('c_time').addEventListener('input', calculateDownTime);
    document.getElementById('d_time').addEventListener('input', calculateDownTime);
    document.getElementById('e_time').addEventListener('input', calculateDownTime);
    document.getElementById('f_time').addEventListener('input', calculateDownTime);
    document.getElementById('g_time').addEventListener('input', calculateDownTime);
    document.getElementById('h_time').addEventListener('input', calculateDownTime);


    document.addEventListener('DOMContentLoaded', function () {

        const b_timeInput = document.getElementById('b_time');
        b_timeInput.addEventListener('input', calculateActualTime);

        // Fungsi untuk menghitung durasi waktu
        function calculateTimeDuration(startInputId, endInputId, durationInputId) {
            const startTimeInput = document.getElementById(startInputId);
            const endTimeInput = document.getElementById(endInputId);
            const durationInput = document.getElementById(durationInputId);

            startTimeInput.addEventListener('input', updateDuration);
            endTimeInput.addEventListener('input', updateDuration);

            function updateDuration() {
            const startTime = new Date(`2000-01-01T${startTimeInput.value}`);
            const endTime = new Date(`2000-01-01T${endTimeInput.value}`);

            // Hitung durasi dalam milidetik
            let duration = endTime - startTime;

            // Konversi durasi menjadi positif jika waktu akhir lebih awal dari waktu awal (misalnya, untuk keesokan harinya)
            if (duration < 0) {
                duration += 24 * 60 * 60 * 1000; // Tambahkan 24 jam dalam milidetik
            }

            // Hitung jam, menit, dan detik dari durasi
            const hours = Math.floor(duration / (60 * 60 * 1000));
            const minutes = Math.floor((duration % (60 * 60 * 1000)) / (60 * 1000));
            const seconds = Math.floor((duration % (60 * 1000)) / 1000);

            // Format durasi sebagai "HH:mm:ss" dan perbarui field input waktu yang sesuai
            const formattedDuration = `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
            durationInput.value = formattedDuration;

            // Hitung ulang total down_time dan actual_time ketika waktu a_time atau b_time diubah
            calculateDownTime();
            calculateActualTime();
            }

            // Inisialisasi durasi ketika halaman pertama kali dimuat
            updateDuration();
        }

        // Panggil fungsi calculateTimeDuration 
        calculateTimeDuration('operating_start_time', 'operating_end_time', 'operating_time');
        calculateDownTime();
        calculateActualTime();
    });

</script>

@endpush