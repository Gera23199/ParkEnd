<?php

namespace App\Services;

use App\Models\Visita;
use App\Models\AnalisisParque;

class AnalisisParqueService
{
    public function calcularPorcentaje($visitantes, $capacidad)
    {
        if ($capacidad <= 0) {
            return 0;
        }

        return ($visitantes / $capacidad) * 100;
    }

    public function clasificarDemanda($porcentaje)
    {
        if ($porcentaje <= 25) {
            return 'Baja';
        } elseif ($porcentaje <= 50) {
            return 'Media';
        } elseif ($porcentaje <= 80) {
            return 'Alta';
        }

        return 'Saturada';
    }

    public function generarRecomendacion($nivel)
    {
        if ($nivel == 'Baja') {
            return 'Recomendada para visitar primero.';
        } elseif ($nivel == 'Media') {
            return 'Puede visitarse con espera moderada.';
        } elseif ($nivel == 'Alta') {
            return 'Se recomienda visitarla en otro horario.';
        }

        return 'Evitar temporalmente o controlar acceso.';
    }

    public function rutaOptima($userId)
    {
        $visitasIds = Visita::where('user_id', $userId)->pluck('id');

        return AnalisisParque::with('atraccion')
            ->whereIn('visita_id', $visitasIds)
            ->orderBy('porcentaje_ocupacion', 'asc')
            ->take(10)
            ->get();
    }
}