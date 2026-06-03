<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AtraccionController;
use App\Http\Controllers\VisitaController;
use App\Http\Controllers\AnalisisParqueController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserManagementController;

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'autenticar'])->name('login.autenticar');

Route::get('/registro', [AuthController::class, 'registro'])->name('registro');
Route::post('/registro', [AuthController::class, 'guardarRegistro'])->name('registro.guardar');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/dashboard/usuarios', [UserManagementController::class, 'index'])->name('usuarios.index');
    Route::get('/api/usuarios', [UserManagementController::class, 'getData'])->name('usuarios.data');
    Route::post('/api/usuarios', [UserManagementController::class, 'store'])->name('usuarios.store');
    Route::put('/api/usuarios/{id}', [UserManagementController::class, 'update'])->name('usuarios.update');
    Route::delete('/api/usuarios/{id}', [UserManagementController::class, 'destroy'])->name('usuarios.destroy');

    Route::get('/perfil', [ProfileController::class, 'index'])->name('perfil.index');
    Route::post('/perfil/password', [ProfileController::class, 'updatePassword'])->name('perfil.password');
    Route::post('/perfil/update', [ProfileController::class, 'updateProfile'])->name('perfil.update');

    Route::resource('atracciones', AtraccionController::class);
    Route::resource('visitas', VisitaController::class);

    Route::get('/analisis', [AnalisisParqueController::class, 'index'])->name('analisis.index');
    Route::post('/analisis/generar', [AnalisisParqueController::class, 'generar'])->name('analisis.generar');
    Route::get('/analisis/ruta-optima', [AnalisisParqueController::class, 'rutaOptima'])->name('analisis.ruta');
});