@extends('layouts.app')

@section('title', 'Editar visita - ParkEnd')

@section('content')

<h2>Editar visita</h2>

@if($errors->any())
    <div class="alert alert-danger">
        <strong>Revisa los datos:</strong>
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="card shadow mt-3">
    <div class="card-body">
        <form action="{{ route('visitas.update', $visita) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Atracción</label>
                <select name="atraccion_id" class="form-control">
                    <option value="">Selecciona una atracción</option>

                    @foreach($atracciones as $atraccion)
                        <option value="{{ $atraccion->id }}" {{ old('atraccion_id', $visita->atraccion_id) == $atraccion->id ? 'selected' : '' }}>
                            {{ $atraccion->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Fecha</label>
                <input type="date" name="fecha" class="form-control" value="{{ old('fecha', $visita->fecha) }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Hora inicio</label>
                <input type="time" name="hora_inicio" class="form-control" value="{{ old('hora_inicio', $visita->hora_inicio) }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Hora fin</label>
                <input type="time" name="hora_fin" class="form-control" value="{{ old('hora_fin', $visita->hora_fin) }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Cantidad de visitantes</label>
                <input type="number" name="cantidad_visitantes" class="form-control" value="{{ old('cantidad_visitantes', $visita->cantidad_visitantes) }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Promoción activa</label>
                <select name="promocion_activa" class="form-control">
                    <option value="0" {{ old('promocion_activa', $visita->promocion_activa) == 0 ? 'selected' : '' }}>No</option>
                    <option value="1" {{ old('promocion_activa', $visita->promocion_activa) == 1 ? 'selected' : '' }}>Sí</option>
                </select>
            </div>

            <button class="btn btn-success">Actualizar</button>
            <a href="{{ route('visitas.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</div>

@endsection