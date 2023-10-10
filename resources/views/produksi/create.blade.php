@extends('adminlte::page')
@section('title', 'Tambah Data Produksi')
<link rel="icon" href="{{ asset('vendor/adminlte/dist/img/icon-title.png') }}" type="image/png">
@section('content_header')
<h1 class="m-0 text-dark">Tambah Data Produksi</h1>
@stop
@section('content')
<form action="{{ route('produksi.store') }}" method="post">
    @csrf
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <label for="name">Nama Operator</label>
                        <div class="input-group">
                            <input type="hidden" name="nama_user" id="nama_user" value="{{ old('nama_user') }}">
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                placeholder="Nama Operator" id="name" name="name" value="{{ auth()->user()->full_name }}"
                                aria-describedby="cari" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="tanggal">Tanggal</label>
                        <input type="date" class="form-control @error('tanggal') is-invalid @enderror" id="tanggal"
                            placeholder="Tanggal" name="tanggal" value="{{ old('tanggal') ?? date('Y-m-d') }}" >
                        @error('tanggal')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="target_quantity">Target Quantity <span class="font-weight-normal">(Otomatis)</span></label>
                        <input type="number" class="form-control @error('target_quantity') is-invalid @enderror"
                            id="target_quantity" placeholder="Target Quantity" name="target_quantity"
                            value="{{ old('target_quantity') }}" readonly>
                        @error('target_quantity')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="daftarkelompok">Kelompok <span class="font-weight-normal">(Otomatis)</span></label>
                        <input type="string" class="form-control @error('daftarkelompok') is-invalid @enderror"
                            id="daftarkelompok" placeholder="kelompok" name="daftarkelompok"
                            value="{{ old('daftarkelompok') }}" readonly>
                        @error('daftarkelompok')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="daftarproses">Nama Proses</label>
                        <select class="form-control mb-10 @error('daftarproses') is-invalid @enderror" id="daftarproses" name="daftarproses" style="width: 100%">
                            <option value="" selected disabled>Pilih Proses..</option>
                            @foreach ($dataproses as $value => $label)
                            <option value="{{ $value }}" @if (old('daftarproses') == $value) selected @endif>{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('daftarproses')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>                 

                    <div class="form-group">
                        <label for="quantity">Actual Quantity</label>
                        <input type="number" class="form-control @error('quantity') is-invalid @enderror" id="quantity"
                            placeholder="Actual Quantity" name="quantity" value="{{ old('quantity') }}">
                        @error('quantity')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
    
                    <div class="form-group" hidden>
                        <label for="finish_good">Good Quality</label>
                        <input type="number" class="form-control @error('finish_good') is-invalid @enderror"
                            id="finish_good" placeholder="Good Quality" name="finish_good"
                            value="{{ old('finish_good') }}" >
                        @error('finish_good')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="reject">Not Good</label>
                        <input type="number" class="form-control @error('reject') is-invalid @enderror" id="reject"
                            Reject="reject" placeholder="Not Good" name="reject" value="{{ old('reject') }}">
                        @error('reject')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="daftarketerangan">Keterangan Not Good</label>
                        <select class="form-control mb-10 @error('daftarketerangan') is-invalid @enderror" id="daftarketerangan" name="daftarketerangan" style="width: 100%">
                            <option value="" selected disabled>Pilih Keterangan..</option>
                            @foreach ($dataketerangan as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('daftarketerangan')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    

                    <div class="row">
                        <div class="col-md-6 border">
                            <div class="form-group">
                                <label for="operating_start_time">Operating Start</label>
                                <input type="time"
                                    class="form-control @error('operating_start_time') is-invalid @enderror"
                                    id="operating_start_time" placeholder="" name="operating_start_time"
                                    value="{{ old('operating_start_time') }}" />
                                @error('operating_start_time')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6 border">
                            <div class="form-group">
                                <label for="operating_end_time">Operating End</label>
                                <input type="time"
                                    class="form-control @error('operating_end_time') is-invalid @enderror"
                                    id="operating_end_time" placeholder="" name="operating_end_time"
                                    value="{{ old('operating_end_time') }}">
                                @error('operating_end_time')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="operating_time">Operating Time</label>
                        <input type="time" class="form-control @error('operating_time') is-invalid @enderror"
                            id="operating_time" placeholder="Operating Time" name="operating_time"
                            value="{{ old('operating_time') }}" readonly>
                        @error('operating_time')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="dropdown">
                        <button class="btn btn-info dropdown-toggle" type="button" id="toggleForm"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Pilih Kategori
                        </button>
                        <div class="dropdown-menu" aria-labelledby="toggleForm">
                            <!-- Checkbox untuk menyembunyikan atau menampilkan form input -->
                            <div class="dropdown-item">
                                <input class="form-check-input" type="checkbox" id="hideFormA" data-target="formA">
                                <label class="form-check-label" for="hideFormA">Kategori A (GANTI ORDER)</label>
                            </div>
                            <div class="dropdown-item">
                                <input class="form-check-input" type="checkbox" id="hideFormB" data-target="formB">
                                <label class="form-check-label" for="hideFormB">Kategori B (REPAIR)</label>
                            </div>
                            <div class="dropdown-item">
                                <input class="form-check-input" type="checkbox" id="hideFormC" data-target="formC">
                                <label class="form-check-label" for="hideFormC">Kategori C (MATERIAL TUNGGU)</label>
                            </div>
                            <div class="dropdown-item">
                                <input class="form-check-input" type="checkbox" id="hideFormD" data-target="formD">
                                <label class="form-check-label" for="hideFormD">Kategori D (OPERATOR)</label>
                            </div>
                            <div class="dropdown-item">
                                <input class="form-check-input" type="checkbox" id="hideFormE" data-target="formE">
                                <label class="form-check-label" for="hideFormE">Kategori E (MAINTENANCE)</label>
                            </div>
                            <div class="dropdown-item">
                                <input class="form-check-input" type="checkbox" id="hideFormF" data-target="formF">
                                <label class="form-check-label" for="hideFormF">Kategori F (CHECKING)</label>
                            </div>
                            <div class="dropdown-item">
                                <input class="form-check-input" type="checkbox" id="hideFormG" data-target="formG">
                                <label class="form-check-label" for="hideFormG">Kategori G (REJECT)</label>
                            </div>
                            <div class="dropdown-item">
                                <input class="form-check-input" type="checkbox" id="hideFormH" data-target="formH">
                                <label class="form-check-label" for="hideFormH">Kategori H (REWORK)</label>
                            </div>
                        </div>
                    </div>

                    <div id="formA">
                        <div class="row">
                            <div class="col-md-6 border">
                                <div class="form-group">
                                    <label for="a_start_time">Kategori A Mulai</label>
                                    <input type="time" class="form-control @error('a_start_time') is-invalid @enderror"
                                        id="a_start_time" placeholder="" name="a_start_time"
                                        value="{{ old('a_start_time') }}">
                                </div>
                            </div>
                            <div class="col-md-6 border">
                                <div class="form-group">
                                    <label for="a_end_time">Kategori A Selesai</label>
                                    <input type="time" class="form-control @error('a_end_time') is-invalid @enderror"
                                        id="a_end_time" placeholder="" name="a_end_time"
                                        value="{{ old('a_end_time') }}">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="a_time">Total Waktu Kategori A</label>
                            <input type="time" class="form-control @error('a_time') is-invalid @enderror" id="a_time"
                                placeholder="A Time" name="a_time" value="{{ old('a_time') }}" readonly>
                        </div>
                    </div>

                    <div id="formB">
                        <div class="row">
                            <div class="col-md-6 border">
                                <div class="form-group">
                                    <label for="b_start_time">Kategori B Mulai</label>
                                    <input type="time" class="form-control @error('b_start_time') is-invalid @enderror"
                                        id="b_start_time" placeholder="" name="b_start_time"
                                        value="{{ old('b_start_time') }}" />

                                </div>
                            </div>
                            <div class="col-md-6 border">
                                <div class="form-group">
                                    <label for="b_end_time">Kategori B Selesai</label>
                                    <input type="time" class="form-control @error('b_end_time') is-invalid @enderror"
                                        id="b_end_time" placeholder="" name="b_end_time"
                                        value="{{ old('b_end_time') }}">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="b_time">Total Waktu Kategori B</label>
                            <input type="time" class="form-control @error('b_time') is-invalid @enderror" id="b_time"
                                placeholder="B Time" name="b_time" value="{{ old('b_time') }}" readonly>
                        </div>
                    </div>

                    <div id="formC">
                        <div class="row">
                            <div class="col-md-6 border">
                                <div class="form-group">
                                    <label for="c_start_time">Kategori C Mulai</label>
                                    <input type="time" class="form-control @error('c_start_time') is-invalid @enderror"
                                        id="c_start_time" placeholder="" name="c_start_time"
                                        value="{{ old('c_start_time') }}" />
                                </div>
                            </div>
                            <div class="col-md-6 border">
                                <div class="form-group">
                                    <label for="c_end_time">Kategori C Selesai</label>
                                    <input type="time" class="form-control @error('c_end_time') is-invalid @enderror"
                                        id="c_end_time" placeholder="" name="c_end_time"
                                        value="{{ old('c_end_time') }}">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="c_time">Total Waktu Kategori C</label>
                            <input type="time" class="form-control @error('c_time') is-invalid @enderror" id="c_time"
                                placeholder="C Time" name="c_time" value="{{ old('c_time') }}" readonly>
                        </div>
                    </div>

                    <div id="formD">
                        <div class="row">
                            <div class="col-md-6 border">
                                <div class="form-group">
                                    <label for="d_start_time">Kategori D Mulai</label>
                                    <input type="time" class="form-control @error('d_start_time') is-invalid @enderror"
                                        id="d_start_time" placeholder="" name="d_start_time"
                                        value="{{ old('d_start_time') }}" />
                                </div>
                            </div>
                            <div class="col-md-6 border">
                                <div class="form-group">
                                    <label for="d_end_time">Kategori D Selesai</label>
                                    <input type="time" class="form-control @error('d_end_time') is-invalid @enderror"
                                        id="d_end_time" placeholder="" name="d_end_time"
                                        value="{{ old('d_end_time') }}">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="d_time">Total Waktu Kategori D</label>
                            <input type="time" class="form-control @error('d_time') is-invalid @enderror" id="d_time"
                                placeholder="D Time" name="d_time" value="{{ old('d_time') }}" readonly>
                        </div>
                    </div>

                    <div id="formE">
                        <div class="row">
                            <div class="col-md-6 border">
                                <div class="form-group">
                                    <label for="e_start_time">Kategori E Mulai</label>
                                    <input type="time" class="form-control @error('e_start_time') is-invalid @enderror"
                                        id="e_start_time" placeholder="" name="e_start_time"
                                        value="{{ old('e_start_time') }}" />
                                </div>
                            </div>
                            <div class="col-md-6 border">
                                <div class="form-group">
                                    <label for="e_end_time">Kategori E Selesai</label>
                                    <input type="time" class="form-control @error('e_end_time') is-invalid @enderror"
                                        id="e_end_time" placeholder="" name="e_end_time"
                                        value="{{ old('e_end_time') }}">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="e_time">Total Waktu Kategori E</label>
                            <input type="time" class="form-control @error('e_time') is-invalid @enderror" id="e_time"
                                placeholder="E Time" name="e_time" value="{{ old('e_time') }}" readonly>
                        </div>
                    </div>

                    <div id="formF">
                        <div class="row">
                            <div class="col-md-6 border">
                                <div class="form-group">
                                    <label for="f_start_time">Kategori F Mulai</label>
                                    <input type="time" class="form-control @error('f_start_time') is-invalid @enderror"
                                        id="f_start_time" placeholder="" name="f_start_time"
                                        value="{{ old('f_start_time') }}" />
                                </div>
                            </div>
                            <div class="col-md-6 border">
                                <div class="form-group">
                                    <label for="f_end_time">Kategori F Selesai</label>
                                    <input type="time" class="form-control @error('f_end_time') is-invalid @enderror"
                                        id="f_end_time" placeholder="" name="f_end_time"
                                        value="{{ old('f_end_time') }}">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="f_time">Total Waktu Kategori F</label>
                            <input type="time" class="form-control @error('f_time') is-invalid @enderror" id="f_time"
                                placeholder="F Time" name="f_time" value="{{ old('f_time') }}" readonly>
                        </div>
                    </div>

                    <div id="formG">
                        <div class="row">
                            <div class="col-md-6 border">
                                <div class="form-group">
                                    <label for="g_start_time">Kategori G Mulai</label>
                                    <input type="time" class="form-control @error('g_start_time') is-invalid @enderror"
                                        id="g_start_time" placeholder="" name="g_start_time"
                                        value="{{ old('g_start_time') }}" />
                                </div>
                            </div>
                            <div class="col-md-6 border">
                                <div class="form-group">
                                    <label for="g_end_time">Kategori G Selesai</label>
                                    <input type="time" class="form-control @error('g_end_time') is-invalid @enderror"
                                        id="g_end_time" placeholder="" name="g_end_time"
                                        value="{{ old('g_end_time') }}">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="g_time">Total Waktu Kategori G</label>
                            <input type="time" class="form-control @error('g_time') is-invalid @enderror" id="g_time"
                                placeholder="G Time" name="g_time" value="{{ old('g_time') }}" readonly>
                        </div>
                    </div>

                    <div id="formH">
                        <div class="row">
                            <div class="col-md-6 border">
                                <div class="form-group">
                                    <label for="h_start_time">Kategori H Mulai</label>
                                    <input type="time" class="form-control @error('h_start_time') is-invalid @enderror"
                                        id="h_start_time" placeholder="" name="h_start_time"
                                        value="{{ old('h_start_time') }}" />
                                </div>
                            </div>
                            <div class="col-md-6 border">
                                <div class="form-group">
                                    <label for="h_end_time">Kategori H Selesai</label>
                                    <input type="time" class="form-control @error('h_end_time') is-invalid @enderror"
                                        id="h_end_time" placeholder="" name="h_end_time"
                                        value="{{ old('h_end_time') }}">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="h_time">Total Waktu Kategori H</label>
                            <input type="time" class="form-control @error('h_time') is-invalid @enderror" id="h_time"
                                placeholder="H Time" name="h_time" value="{{ old('h_time') }}" readonly>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="down_time">Down Time</label>
                        <input type="time" class="form-control @error('down_time') is-invalid @enderror" id="down_time"
                            placeholder="Down Time" name="down_time" value="{{ old('down_time') }}" readonly>
                    </div>

                    <div class="form-group">
                        <label for="actual_time">Actual Time</label>
                        <input type="time" class="form-control @error('actual_time') is-invalid @enderror"
                            id="actual_time" placeholder="Actual Time" name="actual_time"
                            value="{{ old('actual_time') }}" readonly>
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

    function autoFillTargetQuantity() {
        var selectedProses = $('#daftarproses').val();
        var selectedTanggal = $('#tanggal').val();

        // Kirim permintaan AJAX ke server untuk mendapatkan nilai target_quantity_byadmin
        $.ajax({
            url: '/get-target-quantity', // Ubah menjadi route yang sesuai
            method: 'GET',
            data: {
                daftarproses: selectedProses,
                tanggal: selectedTanggal
            },
            success: function(response) {
                if (response.success) {
                    var targetQuantity = response.target_quantity; // Ubah menjadi 'target_quantity'
                    $('#target_quantity').val(targetQuantity);
                } else {
                    $('#target_quantity').val('');
                }
            }
        });
    }

    // Panggil fungsi autoFillTargetQuantity setiap kali nilai 'proses' atau 'tanggal' berubah
    $('#daftarproses, #tanggal').on('change', function() {
        autoFillTargetQuantity();
    });

    // Panggil fungsi saat halaman pertama kali dimuat
    autoFillTargetQuantity();

    function autoFillKelompokan() {
        var selectedProses = $('#daftarproses').val();

        // Kirim permintaan AJAX ke server untuk mendapatkan data kelompok
        $.ajax({
            url: '/get-kelompok-data', // Ubah menjadi route yang sesuai
            method: 'GET',
            data: {
                daftarproses: selectedProses,
            },
            success: function (response) {
                if (response.success) {
                    var daftarkelompok = response.daftarkelompok;
                    $('#daftarkelompok').val(daftarkelompok);
                } else {
                    $('#daftarkelompok').val('');
                }
            },
            error: function () {
                $('#daftarkelompok').val(''); // Handle error dengan mengosongkan nilai kelompokan
            },
        });
    }

    // Panggil fungsi autoFillKelompokan setiap kali nilai 'proses' berubah
    $('#daftarproses').on('change', function () {
        autoFillKelompokan();
    });

    // Panggil fungsi saat halaman pertama kali dimuat
    autoFillKelompokan();


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
  
    // Panggil fungsi untuk mengatur tampilan awal halaman
    toggleForm();

    
    document.addEventListener('DOMContentLoaded', function () {

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

        // Fungsi untuk menghitung total durasi dari a_time sampai f_time dalam menit
        function calculateDownTime() {
            const a_timeInput = document.getElementById('a_time');
            const b_timeInput = document.getElementById('b_time');
            const c_timeInput = document.getElementById('c_time');
            const d_timeInput = document.getElementById('d_time');
            const e_timeInput = document.getElementById('e_time');
            const f_timeInput = document.getElementById('f_time');
            const g_timeInput = document.getElementById('g_time');
            const h_timeInput = document.getElementById('h_time');
            const down_timeInput = document.getElementById('down_time');

            const a_time = a_timeInput.value ? parseDuration(a_timeInput.value) : 0;
            const b_time = b_timeInput.value ? parseDuration(b_timeInput.value) : 0;
            const c_time = c_timeInput.value ? parseDuration(c_timeInput.value) : 0;
            const d_time = d_timeInput.value ? parseDuration(d_timeInput.value) : 0;
            const e_time = e_timeInput.value ? parseDuration(e_timeInput.value) : 0;
            const f_time = f_timeInput.value ? parseDuration(f_timeInput.value) : 0;
            const g_time = g_timeInput.value ? parseDuration(g_timeInput.value) : 0;
            const h_time = h_timeInput.value ? parseDuration(h_timeInput.value) : 0;

            // Hitung total durasi dalam menit
            const totalDurationInMinutes = a_time + b_time + c_time + d_time + e_time + f_time + g_time + h_time;

            // Ubah durasi menjadi format jam dan menit (HH:mm) dan perbarui nilai pada input down_time
            const formattedDuration = `${Math.floor(totalDurationInMinutes / 60).toString().padStart(2, '0')}:${(totalDurationInMinutes % 60).toString().padStart(2, '0')}`;
            down_timeInput.value = formattedDuration;
        }

        // Fungsi untuk menghitung actual_time sebagai selisih dari operating_time dan b_time dalam menit
        function calculateActualTime() {
            const operating_timeInput = document.getElementById('operating_time');
            const b_timeInput = document.getElementById('b_time');
            const actual_timeInput = document.getElementById('actual_time');

            const operating_time = parseDuration(operating_timeInput.value);
            const b_time = b_timeInput.value ? parseDuration(b_timeInput.value) : 0;

            // Hitung actual_time dalam menit
            const actualTimeInMinutes = operating_time - b_time;

            // Ubah durasi menjadi format jam dan menit (HH:mm) dan perbarui nilai pada input actual_time
            const formattedDuration = `${Math.floor(actualTimeInMinutes / 60).toString().padStart(2, '0')}:${(actualTimeInMinutes % 60).toString().padStart(2, '0')}`;
            actual_timeInput.value = formattedDuration;
        }

        // Fungsi bantuan untuk mengonversi durasi dalam format "HH:mm:ss" menjadi menit
        function parseDuration(duration) {
            const [hours, minutes] = duration.split(':').map(Number);
            return (hours * 60) + minutes;
        }

        // Panggil fungsi calculateTimeDuration untuk setiap form A, B, C, D, E, dan F
        calculateTimeDuration('operating_start_time', 'operating_end_time', 'operating_time');
        calculateTimeDuration('a_start_time', 'a_end_time', 'a_time');
        calculateTimeDuration('b_start_time', 'b_end_time', 'b_time');
        calculateTimeDuration('c_start_time', 'c_end_time', 'c_time');
        calculateTimeDuration('d_start_time', 'd_end_time', 'd_time');
        calculateTimeDuration('e_start_time', 'e_end_time', 'e_time');
        calculateTimeDuration('f_start_time', 'f_end_time', 'f_time');
        calculateTimeDuration('g_start_time', 'g_end_time', 'g_time');
        calculateTimeDuration('h_start_time', 'h_end_time', 'h_time');

        // Hitung dan tampilkan nilai down_time dan actual_time
        calculateDownTime();
        calculateActualTime();
    });
</script>

@endpush