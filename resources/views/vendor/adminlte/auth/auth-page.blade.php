@extends('adminlte::master')

@php( $dashboard_url = View::getSection('dashboard_url') ?? config('adminlte.dashboard_url', 'home') )

@if (config('adminlte.use_route_url', false))
    @php( $dashboard_url = $dashboard_url ? route($dashboard_url) : '' )
@else
    @php( $dashboard_url = $dashboard_url ? url($dashboard_url) : '' )
@endif

@section('adminlte_css')
    @stack('css')
    @yield('css')
@stop

@section('classes_body'){{ ($auth_type ?? 'login') . '-page' }}@stop

@section('body')
<div class="image-element">
    <img src="{{ asset('vendor/adminlte/dist/img/MW-88-1.png') }}" style="max-width: 400px; height: auto;">
</div>

    <div class="{{ $auth_type ?? 'login' }}-box">
        {{-- Logo --}}
        <div class="{{ $auth_type ?? 'login' }}-logo">
            <a href="{{ $dashboard_url }}">
            </a>
        </div>
        {{-- Card Box --}}
        <div class="element-card card {{ config('adminlte.classes_auth_card', 'card-outline card-primary') }}">
            {{-- Card Header --}}
            @hasSection('auth_header')
                <div class="card-header {{ config('adminlte.classes_auth_header', '') }}">
                    <h3 class="card-title float-none text-center">
                        @yield('auth_header')
                    </h3>
                </div>
            @endif
            {{-- Card Body --}}
            <div class="card-body {{ $auth_type ?? 'login' }}-card-body {{ config('adminlte.classes_auth_body', '') }}">
                @yield('auth_body')
            </div>
            {{-- Card Footer --}}
            @hasSection('auth_footer')
                <div class="card-footer {{ config('adminlte.classes_auth_footer', '') }}">
                    @yield('auth_footer')
                </div>
            @endif
        </div>
    </div>
</div>
@stop
<style>
    body { 
        background-image: url('{{ asset('vendor/adminlte/dist/img/19742.jpg') }}');
        background-size: cover; 
        background-repeat: no-repeat;
        background-position: center center;
        background-color: #f0f0f0;
        width: 100%;
        height: 100%;
        position: fixed;
        top: 0;
        left: 0;
        z-index: -1; 
    }
    .image-element {
        text-align: center;
    }

    .image-element img {
        max-width: 400px;
        height: auto;
    }
</style>

@section('adminlte_js')
    @stack('js')
    @yield('js')
@stop
