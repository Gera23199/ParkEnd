<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login - ParkEnd</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container min-vh-100 d-flex justify-content-center align-items-center">

    <div class="card shadow" style="width: 420px;">
        <div class="card-body p-4">

            <h2 class="text-center mb-4">ParkEnd</h2>
            <h5 class="text-center mb-4">Iniciar sesión</h5>

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger">
                    Revisa tu correo o contraseña.
                </div>
            @endif

            <form action="{{ route('login.autenticar') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Correo electrónico</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Contraseña</label>
                    <input type="password" name="password" class="form-control">
                </div>

                <button class="btn btn-primary w-100">
                    Iniciar sesión
                </button>
            </form>

            <div class="text-center mt-3">
                <a href="{{ route('registro') }}">Crear una cuenta</a>
            </div>

        </div>
    </div>

</div>

</body>
</html>