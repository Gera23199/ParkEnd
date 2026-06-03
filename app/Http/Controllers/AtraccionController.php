<?php

namespace App\Http\Controllers;

use App\Models\Atraccion;
use Illuminate\Http\Request;

class AtraccionController extends Controller
{
    public function index()
    {
        $atracciones = Atraccion::latest()->get();

        return view('atracciones.index', compact('atracciones'));
    }

    public function create()
    {
        return view('atracciones.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|max:100',
            'tipo' => 'nullable|max:100',
            'capacidad_hora' => 'required|integer|min:1',
            'estado' => 'required'
        ]);

        Atraccion::create($request->all());

        return redirect()->route('atracciones.index')
            ->with('success', 'Atracción registrada correctamente.');
    }

    public function edit(Atraccion $atraccione)
    {
        return view('atracciones.edit', [
            'atraccion' => $atraccione
        ]);
    }

    public function update(Request $request, Atraccion $atraccione)
    {
        $request->validate([
            'nombre' => 'required|max:100',
            'tipo' => 'nullable|max:100',
            'capacidad_hora' => 'required|integer|min:1',
            'estado' => 'required'
        ]);

        $atraccione->update($request->all());

        return redirect()->route('atracciones.index')
            ->with('success', 'Atracción actualizada correctamente.');
    }

    public function destroy(Atraccion $atraccione)
    {
        $atraccione->delete();

        return redirect()->route('atracciones.index')
            ->with('success', 'Atracción eliminada correctamente.');
    }
}