@extends('layouts.app')

@section('title', 'Visitas - ParkEnd')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Registro de visitas</h2>
    <a href="{{ route('visitas.create') }}" class="btn btn-primary">+ Nueva visita</a>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card shadow">
    <div class="card-body">
        @if($visitas->count() > 0)
            <table class="table table-bordered table-striped align-middle">
                <thead>
                    <tr>
                        <th>Atracción</th>
                        <th>Fecha</th>
                        <th>Horario</th>
                        <th>Visitantes</th>
                        <th>Promoción</th>
                        <th>Acciones</th>
                    </tr>
                </thead>

                <tbody>
                @foreach($visitas as $visita)
                    <tr>
                        <td>{{ $visita->atraccion->nombre }}</td>
                        <td>{{ $visita->fecha }}</td>
                        <td>{{ $visita->hora_inicio }} - {{ $visita->hora_fin }}</td>
                        <td>{{ $visita->cantidad_visitantes }}</td>
                        <td>{{ $visita->promocion_activa ? 'Sí' : 'No' }}</td>
                        <td>
                            <a href="{{ route('visitas.edit', $visita) }}" class="btn btn-warning btn-sm">
                                Editar
                            </a>

                            <form action="{{ route('visitas.destroy', $visita) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm">
                                    Eliminar
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @else
            <p class="text-muted">Todavía no hay visitas registradas.</p>
        @endif
    </div>
</div>

@endsection