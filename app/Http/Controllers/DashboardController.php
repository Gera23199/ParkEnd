<?php

namespace App\Http\Controllers;

use App\Models\Atraccion;
use App\Models\Visita;
use App\Models\AnalisisParque;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = auth()->id();

        $totalAtracciones = Atraccion::count();

        $atraccionesActivas = Atraccion::where('estado', 'Activa')->count();

        $totalVisitas = Visita::where('user_id', $userId)
            ->sum('cantidad_visitantes');

        $visitasUsuario = Visita::where('user_id', $userId)
            ->pluck('id');

        $totalAnalisis = AnalisisParque::whereIn('visita_id', $visitasUsuario)
            ->count();

        return view('dashboard.index', compact(
            'totalAtracciones',
            'atraccionesActivas',
            'totalVisitas',
            'totalAnalisis'
        ));
    }
}