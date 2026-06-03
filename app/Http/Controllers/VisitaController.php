<?php

namespace App\Http\Controllers;

use App\Models\Visita;
use App\Models\Atraccion;
use Illuminate\Http\Request;

class VisitaController extends Controller
{
    public function index()
    {
        $visitas = Visita::with(['atraccion', 'user'])
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('visitas.index', compact('visitas'));
    }

    public function create()
    {
        $atracciones = Atraccion::where('estado', 'Activa')->get();

        return view('visitas.create', compact('atracciones'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'atraccion_id' => 'required|exists:atracciones,id',
            'fecha' => 'required|date',
            'hora_inicio' => 'required',
            'hora_fin' => 'required',
            'cantidad_visitantes' => 'required|integer|min:0',
            'promocion_activa' => 'required',
        ]);

        Visita::create([
            'user_id' => auth()->id(),
            'atraccion_id' => $request->atraccion_id,
            'fecha' => $request->fecha,
            'hora_inicio' => $request->hora_inicio,
            'hora_fin' => $request->hora_fin,
            'cantidad_visitantes' => $request->cantidad_visitantes,
            'promocion_activa' => $request->promocion_activa,
        ]);

        return redirect()->route('visitas.index')
            ->with('success', 'Visita registrada correctamente.');
    }

    public function edit(Visita $visita)
    {
        if ($visita->user_id !== auth()->id()) {
            abort(403);
        }

        $atracciones = Atraccion::where('estado', 'Activa')->get();

        return view('visitas.edit', compact('visita', 'atracciones'));
    }

    public function update(Request $request, Visita $visita)
    {
        if ($visita->user_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'atraccion_id' => 'required|exists:atracciones,id',
            'fecha' => 'required|date',
            'hora_inicio' => 'required',
            'hora_fin' => 'required',
            'cantidad_visitantes' => 'required|integer|min:0',
            'promocion_activa' => 'required',
        ]);

        $visita->update([
            'atraccion_id' => $request->atraccion_id,
            'fecha' => $request->fecha,
            'hora_inicio' => $request->hora_inicio,
            'hora_fin' => $request->hora_fin,
            'cantidad_visitantes' => $request->cantidad_visitantes,
            'promocion_activa' => $request->promocion_activa,
        ]);

        return redirect()->route('visitas.index')
            ->with('success', 'Visita actualizada correctamente.');
    }

    public function destroy(Visita $visita)
    {
        if ($visita->user_id !== auth()->id()) {
            abort(403);
        }

        $visita->delete();

        return redirect()->route('visitas.index')
            ->with('success', 'Visita eliminada correctamente.');
    }
}