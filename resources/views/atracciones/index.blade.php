@extends('layouts.app')

@section('title', 'Atracciones - ParkEnd')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Gestión de atracciones</h2>
    <a href="{{ route('atracciones.create') }}" class="btn btn-primary">+ Nueva atracción</a>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card shadow">
    <div class="card-body">
        @if($atracciones->count() > 0)
            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Tipo</th>
                            <th>Capacidad/hora</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>

                    <tbody>
                    @foreach($atracciones as $atraccion)
                        <tr>
                            <td>{{ $atraccion->nombre }}</td>
                            <td>{{ $atraccion->tipo }}</td>
                            <td>{{ $atraccion->capacidad_hora }}</td>
                            <td>
                                <span class="badge {{ $atraccion->estado == 'Activa' ? 'bg-success' : 'bg-secondary' }}">
                                    {{ $atraccion->estado }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('atracciones.edit', $atraccion) }}" class="btn btn-warning btn-sm">
                                    Editar
                                </a>

                                <form action="{{ route('atracciones.destroy', $atraccion) }}" method="POST" class="d-inline">
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
            </div>
        @else
            <p class="text-muted">Todavía no hay atracciones registradas.</p>
        @endif
    </div>
</div>

@endsection