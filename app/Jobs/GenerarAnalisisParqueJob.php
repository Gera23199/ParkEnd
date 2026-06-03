<?php

namespace App\Jobs;

use App\Models\Visita;
use App\Models\AnalisisParque;
use App\Services\AnalisisParqueService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class GenerarAnalisisParqueJob implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public int $visitaId
    ) {}

    public function handle(AnalisisParqueService $service): void
    {
        $visita = Visita::with('atraccion')->find($this->visitaId);

        if (!$visita) {
            return;
        }

        $porcentaje = $service->calcularPorcentaje(
            $visita->cantidad_visitantes,
            $visita->atraccion->capacidad_hora
        );

        $nivel = $service->clasificarDemanda($porcentaje);
        $recomendacion = $service->generarRecomendacion($nivel);

        AnalisisParque::updateOrCreate(
            ['visita_id' => $visita->id],
            [
                'atraccion_id' => $visita->atraccion_id,
                'visitantes_registrados' => $visita->cantidad_visitantes,
                'capacidad_maxima' => $visita->atraccion->capacidad_hora,
                'porcentaje_ocupacion' => $porcentaje,
                'nivel_demanda' => $nivel,
                'recomendacion' => $recomendacion,
            ]
        );
    }
}