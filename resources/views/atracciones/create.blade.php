<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nueva atracción - ParkEnd</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
<div class="container py-4">

    <h2>Nueva atracción</h2>

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
            <form action="{{ route('atracciones.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Nombre</label>
                    <input type="text" name="nombre" class="form-control" value="{{ old('nombre') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Tipo</label>
                    <input type="text" name="tipo" class="form-control" value="{{ old('tipo') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Capacidad por hora</label>
                    <input type="number" name="capacidad_hora" class="form-control" value="{{ old('capacidad_hora') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Estado</label>
                    <select name="estado" class="form-control">
                        <option value="Activa">Activa</option>
                        <option value="Inactiva">Inactiva</option>
                    </select>
                </div>

                <button class="btn btn-success">Guardar</button>
                <a href="{{ route('atracciones.index') }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>

</div>
</body>
</html>