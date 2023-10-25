@extends('adminlte::page')

@section('title', 'Dashboard')
<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
<link rel="icon" href="{{ asset('vendor/adminlte/dist/img/icon-title.png') }}" type="image/png">
@section('content_header')
<div class="d-flex flex-wrap justify-content-between align-items-center">
    <h2>Overall Equipment Effectiveness</h2>
    <form id="filterForm" method="get" class="form-inline">
        @php
        $currentMonth = date('Y-m');
        $selectedMonth = request('filterMonth', $currentMonth); // Ambil bulan terpilih
        @endphp
        <div class="d-flex align-items-center">
            <label for="filterMonth" class="mr-2 mb-2 mb-md-0" style="flex: 0 0 auto;">Month:</label>
            <input type="month" class="form-control" id="filterMonth" name="filterMonth" value="{{ $selectedMonth }}"
                max="{{ $currentMonth }}">
            <button type="submit" class="btn btn-info ml-2">Submit</button>
        </div>
    </form>
</div>
@stop

@section('content')
<div class="row">
    <div class="col-lg-3 col-6">
      <div class="small-box bg-info">
        <div class="inner">
          <h3>{{ $userCount }}</h3>

          <p>Pengguna Sistem</p>
        </div>
        <div class="icon">
            <i class="fa fa-users"></i>
        </div>
        <a class="small-box-footer" style="width: 100%; height: 20px"></a>
      </div>
    </div>
    <div class="col-lg-3 col-6">
      <div class="small-box bg-success">
        <div class="inner">
          <h3>{{ $harianCount }}</h3>

          <p>Data Produksi Hari Ini</p>
        </div>
        <div class="icon">
            <i class="ion ion-stats-bars"></i>
        </div>
        <a class="small-box-footer" style="width: 100%; height: 20px"></a>
      </div>
    </div>
    <div class="col-lg-3 col-6">
      <div class="small-box bg-warning">
        <div class="inner">
          <h3>{{ $bulananCount }}</h3>

          <p>Data Produksi Bulan Ini</p>
        </div>
        <div class="icon">
            <i class="fa fa-chart-bar"></i>
        </div>
        <a class="small-box-footer" style="width: 100%; height: 20px"></a>
      </div>
    </div>
    <div class="col-lg-3 col-6">
      <div class="small-box bg-danger">
        <div class="inner">
          <h3>{{ $operNoData }}</h3>

          <p>Operator Non-Data Hari Ini</p>
        </div>
        <div class="icon">
            <i class="fa fa-exclamation-circle"></i>
        </div>
        <a class="small-box-footer" style="width: 100%; height: 20px"></a>
      </div>
    </div>
</div>
<div class="row">
    @foreach($getData as $kelompok => $data)
    <div class="col-lg-3 col-md-4" id="oeeCard{{ $loop->index }}">
        <div class="card card-info border shadow-lg">
            <div class="card-header d-flex justify-content-between align-items-center bg-gradient-gray-dark"
                style="padding-top: 3px; padding-bottom: 3px;">
                <div class="card-title" style="font-size: 15px">{{ $kelompok }}</div>
                <a class="btn btn-link ml-auto" data-toggle="modal" data-target="#chartModal{{ $loop->index }}">View</a>
            </div>
            <div class="card-body position-relative">
                <canvas id="oeeChart{{ $loop->index }}" width="200" height="250"></canvas>
                <div class="oee-text">
                    <span class="oee-title">OEE</span>
                    <div class="oee-line"></div>
                    <span class="oee-value" id="oee-value{{ $loop->index }}"></span>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

@foreach($getData as $kelompok => $data)
<div class="modal fade" id="chartModal{{ $loop->index }}" tabindex="-1" role="dialog"
    aria-labelledby="chartModalLabel{{ $loop->index }}" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="chartModaLlLabel">{{ $kelompok }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-4 col-md-6 col-xs-6">
                        <div class="card card-success shadow-lg">
                            <div class="card-header">
                                <h3 class="card-title">Performance</h3>
                            </div>
                            <div class="card-body">
                                <div class="card-body text-center">
                                    <h5 class="description-header">Target Quantity</h5>
                                    <span class="description-text text-bold" id="textTargetQuantity{{ $loop->index }}">
                                    </span>
                                </div>
                                <div class="card-body text-center">
                                    <h5 class="description-header">Actual Quantity</h5>
                                    <span class="description-text text-bold" id="textActualQuantity{{ $loop->index }}">
                                    </span>
                                </div>
                                <div class="card-body text-center">
                                    <h5 class="description-header">Percentage</h5>
                                    <span class="description-text text-bold"
                                        id="textPerformancePercentage{{ $loop->index }}">
                                    </span>
                                </div>
                            </div>
                            <div class="card-footer">
                                <canvas id="performanceChart{{ $loop->index }}" width="200" height="200"></canvas>
                                <div class="chart-text">
                                    <span class="chart-title">Performance</span>
                                    <span class="chart-percentage text-bold"
                                        id="performancePercentage{{ $loop->index }}"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-xs-6">
                        <div class="card card-warning shadow-lg">
                            <div class="card-header">
                                <h3 class="card-title">Availability</h3>
                            </div>
                            <div class="card-body">
                                <div class="card-body text-center">
                                    <h5 class="description-header">Total Operation Time</h5>
                                    <span class="description-text text-bold" id="textTotalTime{{ $loop->index }}">
                                    </span>
                                </div>
                                <div class="card-body text-center">
                                    <h5 class="description-header">Actual Runtime</h5>
                                    <span class="description-text text-bold" id="textActualRuntime{{ $loop->index }}">
                                    </span>
                                </div>
                                <div class="card-body text-center">
                                    <h5 class="description-header">Down Time</h5>
                                    <span class="description-text text-bold" id="textDownTime{{ $loop->index }}">
                                    </span>
                                </div>
                            </div>
                            <div class="card-footer">
                                <canvas id="availabilityChart{{ $loop->index }}" width="200" height="200"></canvas>
                                <div class="chart-text">
                                    <span class="chart-title">Availability</span>
                                    <span class="chart-percentage text-bold"
                                        id="availabilityPercentage{{ $loop->index }}"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-xs-6">
                        <div class="card card-danger shadow-lg">
                            <div class="card-header">
                                <h3 class="card-title text-center">Quality</h3>
                            </div>
                            <div class="card-body">
                                <div class="card-body text-center">
                                    <h5 class="description-header">Total Quantity</h5>
                                    <span class="description-text text-bold" id="textTotalQuantity{{ $loop->index }}">
                                    </span>
                                </div>
                                <div class="card-body text-center">
                                    <h5 class="description-header">Good Quantity</h5>
                                    <span class="description-text text-bold" id="textGoodQuantity{{ $loop->index }}">
                                    </span>
                                </div>
                                <div class="card-body text-center">
                                    <h5 class="description-header">Not Good</h5>
                                    <span class="description-text text-bold"
                                        id="textRejectedQuantity{{ $loop->index }}">
                                    </span>
                                </div>
                            </div>
                            <div class="card-footer">
                                <canvas id="qualityChart{{ $loop->index }}" width="200" height="200"></canvas>
                                <div class="chart-text">
                                    <span class="chart-title">Quality</span>
                                    <span class="chart-percentage text-bold"
                                        id="qualityPercentage{{ $loop->index }}" ></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" >Tutup</button>
            </div>
        </div>
    </div>
</div>
@endforeach

<style>
    .card-footer {
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .chart-text {
        position: absolute;
        top: 62%;
        left: 50%;
        transform: translate(-50%, -50%);
        text-align: center;
        z-index: 1;
    }

    .oee-text {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        text-align: center;
    }

    .oee-title {
        font-size: 24px;
        font-weight: bold;
    }

    .oee-line {
        width: 70px;
        height: 3px;
        background-color: #000;
        margin: 5px auto;
    }

    .oee-value {
        font-size: 20px;
        font-weight: bold;
    }

    .card-body {
        padding: 10px;
    }
</style>
@stop

@section('adminlte_js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    var getData = @json($getData);
    var performanceCharts = [];
    var availabilityCharts = [];
    var qualityCharts = [];
    var oeeCharts = []

    $(document).ready(function() {

        $("#searchButton").click(function() {
            var searchText = $("#searchInput").val().toLowerCase();

            // Loop melalui setiap kartu
            $(".col-lg-3").each(function() {
                var cardTitle = $(this).find(".card-title").text().toLowerCase();
                var card = $(this);

                // Periksa apakah judul kartu cocok dengan teks pencarian
                if (cardTitle.includes(searchText)) {
                    card.show(); // Tampilkan kartu jika cocok
                } else {
                    card.hide(); // Sembunyikan kartu jika tidak cocok
                }
            });
        });

        @foreach($getData as $kelompok => $data)
        var data{{ $loop->index }} = {!! json_encode($data) !!}; // Ambil data dari Blade dan konversi menjadi objek JavaScript

        // Membuat dan menginisialisasi grafik performance, availability, dan quality untuk setiap elemen
        createPerformanceChart(data{{ $loop->index }}, "{{ $loop->index }}");
        createAvailabilityChart(data{{ $loop->index }}, "{{ $loop->index }}");
        createQualityChart(data{{ $loop->index }}, "{{ $loop->index }}");
        createOeeChart(data{{ $loop->index }}, "{{ $loop->index }}");

        // Memeriksa apakah data memiliki nilai-nilai default
        if (data{{ $loop->index }}.target_quantity === 0 &&
            data{{ $loop->index }}.operating_time === '00:00:00' &&
            data{{ $loop->index }}.actual_time === '00:00:00' &&
            data{{ $loop->index }}.down_time === '00:00:00' &&
            data{{ $loop->index }}.quantity === 0 &&
            data{{ $loop->index }}.finish_good === 0 &&
            data{{ $loop->index }}.reject === 0) {
            // Mengganti teks pada elemen-elemen dengan "No Data Available"
            $('#textTargetQuantity{{ $loop->index }}').text("No Data Available");
            $('#textActualQuantity{{ $loop->index }}').text("No Data Available");
            $('#textTotalTime{{ $loop->index }}').text("No Data Available");
            $('#textActualRuntime{{ $loop->index }}').text("No Data Available");
            $('#textDownTime{{ $loop->index }}').text("No Data Available");
            $('#textTotalQuantity{{ $loop->index }}').text("No Data Available");
            $('#textGoodQuantity{{ $loop->index }}').text("No Data Available");
            $('#textRejectedQuantity{{ $loop->index }}').text("No Data Available");
            $('#oee-value{{ $loop->index }}').text('No Data Available');
            $('#performancePercentage').text('');
            $('#availabilityPercentage').text('');
            $('#qualityPercentage').text('');
        } else {
            // Mengisi teks pada elemen-elemen dengan data yang sesuai
            $('#textTargetQuantity{{ $loop->index }}').text(data{{ $loop->index }}.target_quantity);
            $('#textActualQuantity{{ $loop->index }}').text(data{{ $loop->index }}.quantity);
            $('#textTotalTime{{ $loop->index }}').text(formatTimeToMinutes(data{{ $loop->index }}.operating_time));
            $('#textActualRuntime{{ $loop->index }}').text(formatTimeToMinutes(data{{ $loop->index }}.actual_time));
            $('#textDownTime{{ $loop->index }}').text(formatTimeToMinutes(data{{ $loop->index }}.down_time));
            $('#textTotalQuantity{{ $loop->index }}').text(data{{ $loop->index }}.quantity);
            $('#textGoodQuantity{{ $loop->index }}').text(data{{ $loop->index }}.finish_good);
            $('#textRejectedQuantity{{ $loop->index }}').text(data{{ $loop->index }}.reject);
        }
    @endforeach

    });

    function formatTimeToMinutes(time) {
        var parts = time.split(':');
        var hours = parseInt(parts[0]);
        var minutes = parseInt(parts[1]);
        var seconds = parseInt(parts[2]);

        var totalMinutes = hours * 60 + minutes + seconds / 60;

        return totalMinutes + ' Minutes';
    }

    function createOeeChart(data, loopIndex) {
        var oeeChartCanvas = document.getElementById('oeeChart' + loopIndex).getContext('2d');
        var totalTarget = data.target_quantity;
        var actualQuantity = data.quantity;
        var actualPercentage = (actualQuantity / totalTarget) * 100;

        var actualTimeInSeconds = convertTimeToSeconds(data.actual_time);
        var downTimeInSeconds = convertTimeToSeconds(data.down_time);
        var totalTimeInSeconds = actualTimeInSeconds + downTimeInSeconds;
        var actualTimePercentage = (actualTimeInSeconds / totalTimeInSeconds) * 100;

        var totalGood = data.finish_good;
        var totalRejected = data.reject;
        var total = totalGood + totalRejected;
        var goodPercentage = (totalGood / total) * 100;

        var oeePercentage = (actualPercentage + actualTimePercentage + goodPercentage) / 3;
        oeePercentage = oeePercentage.toFixed(2);

        var changeColor = (100 - oeePercentage) < 0 ? '#11c51d' : '#E21818';

        var oeeChartData = {
            datasets: [{
                data: [oeePercentage, 100 - oeePercentage],
                backgroundColor: ['#1D5D9B', changeColor]
            }],
        };

        var oeeChart = new Chart(oeeChartCanvas, {
            type: 'doughnut',
            data: oeeChartData,
            options: {
                maintainAspectRatio: false,
                responsive: true,
                plugins: {
                    datalabels: false,
                },
                legend: {
                    display: false
                }
            }
        });

        var oeeValueText = document.getElementById('oee-value' + loopIndex);
        oeeValueText.textContent = oeePercentage + '%';

        if (parseFloat(oeePercentage) > 90.00) {
            oeeValueText.style.color = '#1ce34a'; // Mengubah warna teks menjadi hijau
        } else if (parseFloat(oeePercentage) < 90.00) {
            oeeValueText.style.color = '#ff0000'; // Mengubah warna teks menjadi merah jika tidak memenuhi kondisi pertama
        }

        oeeCharts.push(oeeChart);
    }

    function createPerformanceChart(data, loopIndex) {
        var performanceChartCanvas = document.getElementById('performanceChart' + loopIndex).getContext('2d');
        var totalTarget = data.target_quantity;
        var actualQuantity = data.quantity;
        var targetPercentage = (actualQuantity / totalTarget) * 100;
        var actualPercentage = (actualQuantity / totalTarget) * 100;
        targetPercentage = targetPercentage.toFixed(2);
        actualPercentage = actualPercentage.toFixed(2);

        // Calculate the difference between target and actual quantity
        var difference = actualQuantity - totalTarget;
        var differencePercentage = (difference / totalTarget) * 100;
        differencePercentage = differencePercentage.toFixed(2);

        // Set the difference label based on the difference value
        var differenceLabel = `Difference (${differencePercentage}%)`;
        var performanceChartData = {
            datasets: [{
                data: [actualQuantity, Math.max(0, totalTarget - actualQuantity)],
                backgroundColor: ['#1D5D9B', '#E21818']
            }],
            labels: [`Actual Quantity (${actualPercentage}%)`, differenceLabel]
        };
        
        var performanceChart = new Chart(performanceChartCanvas, {
            type: 'doughnut',
            data: performanceChartData,
            options: {
                maintainAspectRatio: false,
                responsive: true,
                // Additional options for the Performance donut chart
            }
        });
        
        var performancePercentage = parseFloat(actualPercentage);
        $('#performancePercentage' + loopIndex).text(performancePercentage.toFixed(2) + '%');
        var textPerformance = parseFloat(actualPercentage);
        $('#textPerformancePercentage' + loopIndex).text(textPerformance.toFixed(2) + '%');

        // Simpan instance grafik performa dalam array
        performanceCharts.push(performanceChart);
    }

    function createAvailabilityChart(data, loopIndex) {
        var availabilityChartCanvas = document.getElementById('availabilityChart' + loopIndex).getContext('2d');
        if (window.availabilityChart) {
            window.availabilityChart.destroy();
        }
        var actualTimeInSeconds = convertTimeToSeconds(data.actual_time);
        var downTimeInSeconds = convertTimeToSeconds(data.down_time);
        var totalTimeInSeconds = actualTimeInSeconds + downTimeInSeconds;
        var actualTimePercentage = (actualTimeInSeconds / totalTimeInSeconds) * 100;
        var downTimePercentage = (downTimeInSeconds / totalTimeInSeconds) * 100;
        actualTimePercentage = actualTimePercentage.toFixed(2);
        downTimePercentage = downTimePercentage.toFixed(2);

        var availabilityChartData = {
            datasets: [{
                data: [actualTimeInSeconds, downTimeInSeconds],
                backgroundColor: ['#1D5D9B', '#E21818']
            }],
            labels: [`Actual Time (${actualTimePercentage}%)`, `Down Time (${downTimePercentage}%)`]
        };

        var availabilityChart = new Chart(availabilityChartCanvas, {
            type: 'doughnut',
            data: availabilityChartData,
            options: {
                maintainAspectRatio: false,
                responsive: true,
            }
        });

        var availabilityPercentage = parseFloat(actualTimePercentage);
        $('#availabilityPercentage' + loopIndex).text(availabilityPercentage.toFixed(2) + '%');

        // Simpan instance grafik dalam array
        availabilityCharts.push(availabilityChart);
    }

    function convertTimeToSeconds(time) {
        var parts = time.split(':');
        var hours = parseInt(parts[0]);
        var minutes = parseInt(parts[1]);
        var totalSeconds = (hours * 3600) + (minutes * 60);
        return totalSeconds;
    }

    function createQualityChart(data, loopIndex) {
        var qualityChartCanvas = document.getElementById('qualityChart' + loopIndex).getContext('2d');
        var totalGood = data.finish_good;
        var totalRejected = data.reject;
        var total = totalGood + totalRejected;
        var goodPercentage = (totalGood / total) * 100;
        var rejectedPercentage = (totalRejected / total) * 100;
        goodPercentage = goodPercentage.toFixed(2);
        rejectedPercentage = rejectedPercentage.toFixed(2);

        var qualityChartData = {
            datasets: [{
                data: [totalGood, totalRejected],
                backgroundColor: ['#1D5D9B', '#E21818'] // Ganti dengan warna yang sesuai
            }],
            labels: [`Good Quantity (${goodPercentage}%)`, `Not Good (${rejectedPercentage}%)`]
        };

        var qualityChart = new Chart(qualityChartCanvas, {
            type: 'doughnut',
            data: qualityChartData,
            options: {
                maintainAspectRatio: false,
                responsive: true,
                // Additional options for the Quality donut chart
            }
        });

        var qualityPercentage = parseFloat(goodPercentage);
        $('#qualityPercentage' + loopIndex).text(qualityPercentage.toFixed(2) + '%');

        // Simpan instance grafik dalam array
        qualityCharts.push(qualityChart);
    }

</script>


@stop