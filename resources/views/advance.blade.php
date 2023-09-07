@extends('adminlte::page')
@section('title', 'Dashboard')
@section('content_header')

@stop
@section('content')
<div class="row">
    @for ($i = 1; $i <= 12; $i++)
    <div class="col-md-3">
        <div class="card">
            <div class="card-header">
                Grafik {{ $i }}
            </div>
            <div class="card-body">
                <canvas id="chart{{ $i }}"></canvas>
            </div>  
        </div>
    </div>
    @endfor
</div>
@stop
@push('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Code untuk membuat chart
    @for ($i = 1; $i <= 12; $i++)
    var ctx{{ $i }} = document.getElementById('chart{{ $i }}').getContext('2d');
    var chart{{ $i }} = new Chart(ctx{{ $i }}, {
        type: 'bar', // Ganti tipe chart sesuai kebutuhan
        data: {
            labels: ['Label 1', 'Label 2', 'Label 3', 'Label 4', 'Label 5'],
            datasets: [{
                label: 'Data {{ $i }}',
                data: [10, 20, 30, 40, 50], // Ganti data sesuai kebutuhan
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
    @endfor
</script>
@endpush
