@extends('adminlte::auth.auth-page', ['auth_type' => 'register'])

@section('title') 
    Register | {{ config('adminlte.title') }}
@stop

<link rel="icon" href="{{ asset('vendor/adminlte/dist/img/icon-title.png') }}" type="image/png">

@php( $login_url = View::getSection('login_url') ?? config('adminlte.login_url', 'login') )
@php( $register_url = View::getSection('register_url') ?? config('adminlte.register_url', 'register') )

@if (config('adminlte.use_route_url', false))
@php( $login_url = $login_url ? route($login_url) : '' )
@php( $register_url = $register_url ? route($register_url) : '' )
@else
@php( $login_url = $login_url ? url($login_url) : '' )
@php( $register_url = $register_url ? url($register_url) : '' )
@endif

@section('auth_header', __('Registrasi Admin'))

@section('auth_body')
<form action="{{ $register_url }}" method="post">
    @csrf
    {{-- Username Field --}}
    <div class="input-group mb-3">
        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
            value="{{ old('name') }}" placeholder="{{ __('Username') }}" autofocus autocomplete="username">

        <div class="input-group-append">
            <div class="input-group-text">
                <span class="fas fa-user {{ config('adminlte.classes_auth_icon', '') }}"></span>
            </div>
        </div>

        @error('name')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>

    {{-- Full Name Field --}}
    <div class="input-group mb-3">
        <input type="text" name="full_name" class="form-control @error('full_name') is-invalid @enderror"
            value="{{ old('full_name') }}" placeholder="{{ __('Nama Lengkap') }}" autofocus autocomplete="name">

        <div class="input-group-append">
            <div class="input-group-text">
                <span class="fas fa-address-card {{ config('adminlte.classes_auth_icon', '') }}"></span>
            </div>
        </div>

        @error('full_name')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>

    {{-- Password field --}}
    <div class="input-group mb-3">
        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
            placeholder="{{ __('adminlte::adminlte.password') }}" autocomplete="new-password">

        <div class="input-group-append">
            <div class="input-group-text">
                <span class="fas fa-lock {{ config('adminlte.classes_auth_icon', '') }}"></span>
            </div>
        </div>

        @error('password')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>

    {{-- Confirm password field --}}
    <div class="input-group mb-3">
        <input type="password" name="password_confirmation"
            class="form-control @error('password_confirmation') is-invalid @enderror"
            placeholder="{{ __('adminlte::adminlte.retype_password') }}" autocomplete="new-password">

        <div class="input-group-append">
            <div class="input-group-text">
                <span class="fas fa-lock {{ config('adminlte.classes_auth_icon', '') }}"></span>
            </div>
        </div>

        @error('password_confirmation')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>

    {{-- Role field --}}
    <div class="input-group mb-3" hidden>
        <select name="role" class="form-control @error('role') is-invalid @enderror">
            <option value="Admin" {{ old('role')==='Admin' ? 'selected' : '' }}>Admin</option>
            <option value="Operator" {{ old('role')==='Operator' ? 'selected' : '' }}>Operator</option>
        </select>

        <div class="input-group-append">
            <div class="input-group-text">
                <span class="fas fa-id-card {{ config('adminlte.classes_auth_icon', '') }}"></span>
            </div>
        </div>

        @error('role')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>

    {{-- Register button --}}
    <button type="submit" class="btn btn-block {{ config('adminlte.classes_auth_btn', 'btn-flat btn-info') }}">
        <span class="fas fa-user-plus"></span>
        {{ __('adminlte::adminlte.register') }}
    </button>

</form>
@stop