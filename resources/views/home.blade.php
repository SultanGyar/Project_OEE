@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
<div class="d-flex flex-wrap justify-content-between align-items-center mb-2">
    <h2>Overall Equipment Effectiveness</h2>
    <form id="filterForm" method="get" class="form-inline">
        @php
        $currentMonth = date('Y-m');
        $selectedMonth = request('filterMonth', $currentMonth); // Ambil bulan terpilih
        @endphp
        <div class="d-flex align-items-center">
            <label for="filterMonth" class="mr-2 mb-2 mb-md-0" style="flex: 0 0 auto;">Bulan:</label>
            <input type="month" class="form-control" id="filterMonth" name="filterMonth" 
            value="{{ $selectedMonth }}" max="{{ $currentMonth }}">
            <button type="submit" class="btn btn-info ml-2">Submit</button>
        </div>
    </form>
</div>
@stop


@section('content')
<div class="row">
    <div class="col-lg-3 col-md-6 col-xs-6">
        <div class="card border card-info shadow-lg">
            <div class="card-header d-flex justify-content-between align-items-center"
                style="padding-top: 5px; padding-bottom: 5px;">
                <h3 class="card-title">nama grup proses</h3>
                <a class="btn btn-link ml-auto" data-toggle="modal" data-target="#chartModal">detail</a>
            </div>
            <div class="card-body position-relative">
                <canvas id="oeeChart" width="200" height="200"></canvas>
                <div class="oee-text">
                    <span class="oee-title">OEE</span>
                    <div class="oee-line"></div>
                    <span class="oee-value"></span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="chartModal" tabindex="-1" role="dialog" aria-labelledby="chartModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="chartModalLabel">Detail Grafik</h5>
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
                                    <span class="description-text text-bold" id="textTargetQuantity"> </span>
                                </div>
                                <div class="card-body text-center">
                                    <h5 class="description-header">Actual Quantity</h5>
                                    <span class="description-text text-bold" id="textActualQuantity"> </span>
                                </div>
                                <div class="card-body text-center">
                                    <h5 class="description-header">Percentage</h5>
                                    <span class="description-text text-bold" id="textPerformancePercentage"> </span>
                                </div>
                            </div>
                            <div class="card-footer">
                                <canvas id="performanceChart" width="200" height="200"></canvas>
                                <div class="chart-text">
                                    <span class="chart-title">Performance</span>
                                    <span class="chart-percentage text-bold" id="performancePercentage"></span>
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
                                    <span class="description-text text-bold" id="textTotalTime"> </span>
                                </div>
                                <div class="card-body text-center">
                                    <h5 class="description-header">Actual Runtime</h5>
                                    <span class="description-text text-bold" id="textActualRuntime"> </span>
                                </div>
                                <div class="card-body text-center">
                                    <h5 class="description-header">Down Time</h5>
                                    <span class="description-text text-bold" id="textDownTime"> </span>
                                </div>
                            </div>
                            <div class="card-footer">
                                <canvas id="availabilityChart" width="200" height="200"></canvas>
                                <div class="chart-text">
                                    <span class="chart-title">Availability</span>
                                    <span class="chart-percentage text-bold" id="availabilityPercentage"></span>
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
                                    <span class="description-text text-bold" id="textTotalQuantity"> </span>
                                </div>
                                <div class="card-body text-center">
                                    <h5 class="description-header">Good Quantity</h5>
                                    <span class="description-text text-bold" id="textGoodQuantity"> </span>
                                </div>
                                <div class="card-body text-center">
                                    <h5 class="description-header">Not Good</h5>
                                    <span class="description-text text-bold" id="textRejectedQuantity"> </span>
                                </div>
                            </div>
                            <div class="card-footer">
                                <canvas id="qualityChart" width="200" height="200"></canvas>
                                <div class="chart-text">
                                    <span class="chart-title">Quality</span>
                                    <span class="chart-percentage text-bold" id="qualityPercentage"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

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

    .chart-title {
        font-size: 15px;
        font-weight: bold;
    }


    .oee-text {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        text-align: center;
        z-index: 1;
        /* Add z-index to ensure the text is displayed above the canvas */
    }

    .oee-title {
        font-size: 24px;
        font-weight: bold;
    }

    .oee-line {
        width: 50px;
        height: 2px;
        background-color: #000;
        margin: 10px auto;
    }

    .oee-value {
        font-size: 18px;
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
        margin: 10px auto;
    }

    .oee-value {
        font-size: 25px;
    }

    .card-body {
        padding: 10px;
    }

    .description-header {
        margin-bottom: 0;
    }

    .description-text {
        margin-top: 0;
    }
</style>
@stop

@section('adminlte_js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.1/js/select2.full.min.js"></script>
<script>
   $(document).ready(function() {
    // Fungsi untuk mengambil dan menggambar grafik
    function fetchDataAndDrawChart(selectedMonth) {
        $.ajax({
            url: '/get-data-for-chart',
            type: 'GET',
            data: {
                filterMonth: selectedMonth
            },
            dataType: 'json',
            success: function(data) {
                // Data telah diterima, lakukan pengolahan data dan menggambar grafik
                console.log('data yang didapat', data);
                // ... Logika untuk menggambar grafik ...
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    }

    // Panggil fetchDataAndDrawChart saat halaman pertama dimuat
    var currentMonth = new Date().toISOString().slice(0, 7);
    fetchDataAndDrawChart(currentMonth);

    // Tangani pengiriman formulir saat tombol "Submit" ditekan
    $('#filterForm').on('submit', function(event) {
        event.preventDefault(); // Mencegah pengiriman formulir standar

        var selectedMonth = $('#filterMonth').val();
        fetchDataAndDrawChart(selectedMonth);
    });
});


</script>
@stop