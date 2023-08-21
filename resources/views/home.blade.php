@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
<h1 class="m-0 text-dark">Dashboard</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <div class="card-body">
            <div class="card-header">
                <h4 class="card-title-center text-center text-dark">Overall Equipment Effectiveness</h4>
            </div>
            <p></p>
            <div class="container">
                <div class="row">
                    <div class="col-lg-5">
                        <div class="form-group">
                            <select class="form-control" id="selectProses">
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div class="form-group">
                            <input type="month" class="form-control" id="selectBulan">
                        </div>
                    </div>
                    <div class="col-lg-2 mb-2">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-3.8">
                    <div class="card border card-info shadow-lg">
                        <div class="card-header">
                            <h3 class="card-title">Performance Indicator</h3>
                        </div>
                        <div class="card-body position-relative">
                            <canvas id="oeeChart" width="200" height="425"></canvas>
                            <div class="oee-text">
                                <span class="oee-title">OEE</span>
                                <div class="oee-line"></div>
                                <span class="oee-value"></span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-3.5">
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

                <div class="col-lg-3 col-md-6 col-sm-3.5">
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

                <div class="col-lg-3 col-md-6 col-sm-3.5">
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
    var performanceChart;
    var availabilityChart;
    var qualityChart;
    var oeeChart;
    var updateData
    $(document).ready(function() {
        $.ajax({
            url: '/get-proses-data',
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                var selectProses = $('#selectProses');
                selectProses.empty();
                $.each(data, function(index, value) {
                    selectProses.append('<option value="' + value.proses + '">' + value.proses + '</option>');
                });

                var currentMonth = new Date().toISOString().slice(0, 7);
                selectBulan.val(currentMonth);
                fetchDataAndDrawChart();
                
            }
        });
        var selectProses = $('#selectProses');
        var selectBulan = $('#selectBulan');

        function fetchDataAndDrawChart() {
            var selectedProses = selectProses.val();
            var selectedBulan = selectBulan.val();

            $.ajax({
                url: '/filter-chart-data',
                type: 'GET',
                data: {
                    proses: selectedProses,
                    bulan: selectedBulan
                },
                dataType: 'json',
                success: function(updateData) {
                    console.log('update', updateData);
                    if (isDataEmpty(updateData)) {
                        clearChartsAndDisplayNoData();
                    } else {
                        createPerformanceChart(updateData.performance);
                        createAvailabilityChart(updateData.availability);
                        createQualityChart(updateData.quality);
                        createOeeChart(updateData.performance, updateData.availability, updateData.quality);

                        $('#textTargetQuantity').text(updateData.performance.target_quantity);
                        $('#textActualQuantity').text(updateData.performance.quantity);
                        $('#textTotalTime').text(formatTime(updateData.availability.operating_time));
                        $('#textActualRuntime').text(formatTime(updateData.availability.actual_time));
                        $('#textDownTime').text(formatTime(updateData.availability.down_time));
                        $('#textTotalQuantity').text(updateData.quality.quantity);
                        $('#textGoodQuantity').text(updateData.quality.finish_good);
                        $('#textRejectedQuantity').text(updateData.quality.reject);
                    }
                },
                error: function() {
                    clearChartsAndDisplayNoData();
                }
            });
            function formatTime(time) {
                var parts = time.split(':');
                var hours = parseInt(parts[0]);
                var minutes = parseInt(parts[1]);
                var hoursText = hours > 0 ? hours + ' Hours ' : '';
                var minutesText = minutes > 0 ? minutes + ' Minutes' : '';
                return hoursText + minutesText;
            }   
        }
        function clearChartsAndDisplayNoData() {
            if (window.performanceChart) {
                window.performanceChart.destroy();
            }
            if (window.availabilityChart) {
                window.availabilityChart.destroy();
            }
            if (window.qualityChart) {
                window.qualityChart.destroy();
            }
            if (window.oeeChart) {
                window.oeeChart.destroy();
            }
            
            $('#textTargetQuantity').text('No Data Available');
            $('#textActualQuantity').text('No Data Available');
            $('#textTotalTime').text('No Data Available');
            $('#textActualRuntime').text('No Data Available');
            $('#textDownTime').text('No Data Available');
            $('#textTotalQuantity').text('No Data Available');
            $('#textGoodQuantity').text('No Data Available');
            $('#textRejectedQuantity').text('No Data Available');
            $('#textPerformancePercentage').text('No Data Available');
            $('.oee-value').text('No Data Available');
            $('#performancePercentage').text('');
            $('#availabilityPercentage').text('');
            $('#qualityPercentage').text('');
        }

        function isDataEmpty(data) {
            return (
                !data.performance ||
                !data.availability ||
                !data.quality ||
                Object.keys(data.performance).length === 0 ||
                Object.keys(data.availability).length === 0 ||
                Object.keys(data.quality).length === 0
            );
        }

        function createPerformanceChart(data) {
            var performanceChartCanvas = document.getElementById('performanceChart').getContext('2d');
            if (window.performanceChart) {
                window.performanceChart.destroy();
            }
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
            window.performanceChart = new Chart(performanceChartCanvas, {
                type: 'doughnut',
                data: performanceChartData,
                options: {
                    maintainAspectRatio: false,
                    responsive: true,
                    // Additional options for the Performance donut chart
                }
            });
            var performancePercentage = parseFloat(actualPercentage); // Konversi ke tipe float
            document.getElementById('performancePercentage').innerText = performancePercentage.toFixed(2) + '%'; // Tampilkan dengan 2 desimal
            var textPerformance = parseFloat(actualPercentage); // Konversi ke tipe float
            document.getElementById('textPerformancePercentage').innerText = textPerformance.toFixed(2) + '%';

        }

        function createAvailabilityChart(data) {
            var availabilityChartCanvas = document.getElementById('availabilityChart').getContext('2d');
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

            window.availabilityChart = new Chart(availabilityChartCanvas, {
                type: 'doughnut',
                data: availabilityChartData,
                options: {
                    maintainAspectRatio: false,
                    responsive: true,
                }
            });
            var availabilityPercentage = parseFloat(actualTimePercentage);
            document.getElementById('availabilityPercentage').innerText = availabilityPercentage.toFixed(2) + '%';
        }
        

        function convertTimeToSeconds(time) {
            var parts = time.split(':');
            var hours = parseInt(parts[0]);
            var minutes = parseInt(parts[1]);
            var totalSeconds = (hours * 3600) + (minutes * 60);
            return totalSeconds;
        }

        function createQualityChart(data) {
            var qualityChartCanvas = document.getElementById('qualityChart').getContext('2d');
            if (window.qualityChart) {
                window.qualityChart.destroy();
            }
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

            window.qualityChart = new Chart(qualityChartCanvas, {
                type: 'doughnut',
                data: qualityChartData,
                options: {
                    maintainAspectRatio: false,
                    responsive: true,
                    // Additional options for the Quality donut chart
                }
            });
            var qualityPercentage = parseFloat(goodPercentage);
            document.getElementById('qualityPercentage').innerText = qualityPercentage.toFixed(2) + '%';
        }

        function createOeeChart(performanceData, availabilityData, qualityData) {
            var oeeChartCanvas = document.getElementById('oeeChart').getContext('2d');
            if (window.oeeChart) {
                window.oeeChart.destroy();
            }
            // menghitung kembali actual percentage
            var totalTarget = performanceData.target_quantity;
            var actualQuantity = performanceData.quantity;
            var actualPercentage = (actualQuantity / totalTarget) * 100;
            
            //menghitung kembali actualTimePercentage
            var actualTimeInSeconds = convertTimeToSeconds(availabilityData.actual_time);
            var downTimeInSeconds = convertTimeToSeconds(availabilityData.down_time);
            var totalTimeInSeconds = actualTimeInSeconds + downTimeInSeconds;
            var actualTimePercentage = (actualTimeInSeconds / totalTimeInSeconds) * 100;
            
            //menghitung kembali goodPercentage
            var totalGood = qualityData.finish_good;
            var totalRejected = qualityData.reject;
            var total = totalGood + totalRejected;
            var goodPercentage = (totalGood / total) * 100;
            
            var oeePercentage = (actualPercentage + actualTimePercentage + goodPercentage) / 3;
            oeePercentage = oeePercentage.toFixed(2);

            var oeeChartData = {
                datasets: [{
                    data: [oeePercentage, 100 - oeePercentage],
                    backgroundColor: ['#1A508B', '#E21818']
                }]
            };

            window.oeeChart = new Chart(oeeChartCanvas, {
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
            var oeeValueText = document.querySelector('.oee-value');
            oeeValueText.textContent = oeePercentage + '%';
        }

        // Panggil fungsi fetchDataAndDrawChart saat tombol Submit ditekan
        $('.btn-primary').click(function() {
                console.log('Submit button clicked');
                fetchDataAndDrawChart();
            });
        
    });

</script>

@stop