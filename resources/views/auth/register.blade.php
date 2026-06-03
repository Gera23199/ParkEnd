<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro - ParkEnd</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container min-vh-100 d-flex justify-content-center align-items-center">

    <div class="card shadow" style="width: 450px;">
        <div class="card-body p-4">

            <h2 class="text-center mb-4">ParkEnd</h2>
            <h5 class="text-center mb-4">Crear cuenta</h5>

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

            <form action="{{ route('registro.guardar') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Nombre</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Correo electrónico</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Contraseña</label>
                    <input type="password" name="password" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">Confirmar contraseña</label>
                    <input type="password" name="password_confirmation" class="form-control">
                </div>

                <button class="btn btn-success w-100">
                    Registrar usuario
                </button>
            </form>

            <div class="text-center mt-3">
                <a href="{{ route('login') }}">Ya tengo cuenta</a>
            </div>

        </div>
    </div>

</div>

</body>
</html>