<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nueva visita - ParkEnd</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
<div class="container py-4">

    <h2>Nueva visita</h2>

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
            <form action="{{ route('visitas.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Atracción</label>
                    <select name="atraccion_id" class="form-control">
                        <option value="">Selecciona una atracción</option>
                        @foreach($atracciones as $atraccion)
                            <option value="{{ $atraccion->id }}">{{ $atraccion->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Fecha</label>
                    <input type="date" name="fecha" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">Hora inicio</label>
                    <input type="time" name="hora_inicio" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">Hora fin</label>
                    <input type="time" name="hora_fin" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">Cantidad de visitantes</label>
                    <input type="number" name="cantidad_visitantes" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">Promoción activa</label>
                    <select name="promocion_activa" class="form-control">
                        <option value="0">No</option>
                        <option value="1">Sí</option>
                    </select>
                </div>

                <button class="btn btn-success">Guardar</button>
                <a href="{{ route('visitas.index') }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>

</div>
</body>
</html>