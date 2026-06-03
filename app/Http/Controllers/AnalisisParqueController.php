<?php

namespace App\Http\Controllers;

use App\Models\Visita;
use App\Models\Atraccion;
use App\Models\AnalisisParque;
use App\Services\AnalisisParqueService;
use App\Jobs\GenerarAnalisisParqueJob;
use Illuminate\Http\Request;

class AnalisisParqueController extends Controller
{
    public function index(Request $request)
    {
        $userId = auth()->id();

        $atracciones = Atraccion::where('estado', 'Activa')->get();

        $visitas = Visita::with('atraccion')
            ->where('user_id', $userId)
            ->latest()
            ->take(50)
            ->get();

        $visitasIds = Visita::where('user_id', $userId)->pluck('id');

        $consulta = AnalisisParque::with(['atraccion', 'visita'])
            ->whereIn('visita_id', $visitasIds);

        if ($request->filled('atraccion_id')) {
            $consulta->where('atraccion_id', $request->atraccion_id);
        }

        if ($request->filled('fecha_inicio') && $request->filled('fecha_fin')) {
            $consulta->whereHas('visita', function ($query) use ($request, $userId) {
                $query->where('user_id', $userId)
                    ->whereBetween('fecha', [
                        $request->fecha_inicio,
                        $request->fecha_fin
                    ]);
            });
        }

        if ($request->filled('nivel_demanda')) {
            $consulta->where('nivel_demanda', $request->nivel_demanda);
        }

        $analisis = $consulta->latest()->get();

        $rutaOptima = app(AnalisisParqueService::class)->rutaOptima($userId);

        return view('analisis.index', compact(
            'atracciones',
            'visitas',
            'analisis',
            'rutaOptima'
        ));
    }

    public function generar(Request $request)
    {
        $request->validate([
            'visita_id' => 'required|exists:visitas,id',
        ]);

        $visita = Visita::where('id', $request->visita_id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        GenerarAnalisisParqueJob::dispatch($visita->id);

        return redirect()->route('analisis.index')
            ->with('success', 'Se realizó el proceso de análisis de forma exitosa.');
    }

    public function rutaOptima()
    {
        return redirect()->route('analisis.index');
    }
}