@extends('layouts.app')

@section('title', 'Dashboard - ParkEnd')

@section('content')

<h2 class="mb-4">Dashboard</h2>

<div class="row">

    <div class="col-md-3 mb-3">
        <div class="card shadow text-center">
            <div class="card-body">
                <h6>Total atracciones</h6>
                <h2>{{ $totalAtracciones }}</h2>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="card shadow text-center">
            <div class="card-body">
                <h6>Atracciones activas</h6>
                <h2>{{ $atraccionesActivas }}</h2>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="card shadow text-center">
            <div class="card-body">
                <h6>Visitantes registrados</h6>
                <h2>{{ $totalVisitas }}</h2>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="card shadow text-center">
            <div class="card-body">
                <h6>Análisis generados</h6>
                <h2>{{ $totalAnalisis }}</h2>
            </div>
        </div>
    </div>

</div>

@endsection