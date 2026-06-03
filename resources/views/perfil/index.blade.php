@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Mi Perfil</h2>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row">
       
        <div class="col-md-4 mb-4">
            
            <div class="card mb-4 shadow-sm border-0">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Información personal</h5>
                </div>
                <div class="card-body">
                    <p><strong>Nombre:</strong> <br> {{ $user->name }}</p>
                    <p><strong>Correo:</strong> <br> {{ $user->email }}</p>
                    <p><strong>Fecha de registro:</strong> <br> {{ $user->created_at->timezone('America/Mexico_City')->format('d/m/Y') }}</p>
                    <p><strong>Cantidad de accesos:</strong> <br> {{ $user->login_count }}</p>
                    <hr>
                    <button class="btn btn-outline-primary btn-sm w-100 mb-2" data-bs-toggle="modal" data-bs-target="#editProfileModal">Editar perfil</button>
                    <button class="btn btn-outline-secondary btn-sm w-100" data-bs-toggle="modal" data-bs-target="#changePasswordModal">Cambiar contraseña</button>
                </div>
            </div>

            <div class="card mb-4 shadow-sm border-0">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0">Visitas para descuento</h5>
                </div>
                <div class="card-body text-center">
                    <h4 class="text-primary fw-bold">{{ $clasificacion }}</h4>
                    <span class="badge bg-success fs-5 mb-3">{{ $descuentoInfo }} de descuento</span>
                    <p class="text-muted small">Has visitado <strong>{{ $totalVisitas }}</strong> atracciones en total.</p>
                    <div class="progress" style="height: 20px;">
                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-info" role="progressbar" style="width: {{ $progress }}%" aria-valuenow="{{ $progress }}" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </div>



        </div>

        <!-- Columna Derecha (Historial y Rutas) -->
        <div class="col-md-8">
            
            <div class="card mb-4 shadow-sm border-0">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0 text-primary">Atracción más visitada</h5>
                </div>
                <div class="card-body text-center py-4">
                    @if($atraccionFavorita)
                        <h3 class="text-dark fw-bold mb-0">{{ $atraccionFavorita->nombre }}</h3>
                        <p class="text-muted mt-2">¡Es tu lugar favorito en el parque!</p>
                    @else
                        <p class="text-muted mb-0">Aún no has visitado ninguna atracción.</p>
                    @endif
                </div>
            </div>

            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0 text-dark">Historial de visitas</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Fecha</th>
                                    <th>Atracción</th>
                                    <th>Horario</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($visitas as $visita)
                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($visita->fecha)->format('d/m/Y') }}</td>
                                        <td><strong>{{ optional($visita->atraccion)->nombre ?? 'Atracción eliminada' }}</strong></td>
                                        <td>{{ \Carbon\Carbon::parse($visita->hora_inicio)->format('H:i') }} - {{ \Carbon\Carbon::parse($visita->hora_fin)->format('H:i') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center text-muted py-4">Aún no tienes visitas registradas.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Modal Cambiar Contraseña -->
<div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="changePasswordModalLabel">Cambiar Contraseña</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ route('perfil.password') }}" method="POST">
          @csrf
          <div class="modal-body">
              <div class="mb-3">
                  <label class="form-label">Contraseña actual</label>
                  <input type="password" name="current_password" class="form-control" required>
              </div>
              <div class="mb-3">
                  <label class="form-label">Nueva contraseña</label>
                  <input type="password" name="new_password" class="form-control" required>
              </div>
              <div class="mb-3">
                  <label class="form-label">Confirmar contraseña</label>
                  <input type="password" name="new_password_confirmation" class="form-control" required>
              </div>
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
              <button type="submit" class="btn btn-primary">Actualizar Contraseña</button>
          </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Editar Perfil -->
<div class="modal fade" id="editProfileModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Editar Perfil</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ route('perfil.update') }}" method="POST">
          @csrf
          <div class="modal-body">
              <div class="mb-3">
                  <label class="form-label">Nombre</label>
                  <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
              </div>
              <div class="mb-3">
                  <label class="form-label">Correo electrónico</label>
                  <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
              </div>
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
              <button type="submit" class="btn btn-primary">Guardar Cambios</button>
          </div>
      </form>
    </div>
  </div>
</div>

@endsection
