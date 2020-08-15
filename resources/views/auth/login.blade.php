@extends('layouts.app')

@push('styles')
    <style>
        body{
            background: linear-gradient(45deg, #53DDAB, #67CAA6), url("{{ asset('assets/images/bg-login.jpg')  }}") !important;
            width:100%;
            height:100vh;
            background-size:cover !important;
            background-position: center center !important;
            background-repeat: no-repeat !important;
            background-blend-mode: overlay !important;
            position:relative;
        }
    </style>
@endpush
@section('content')
    <Authentication></Authentication>
@endsection
