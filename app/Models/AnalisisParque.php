<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnalisisParque extends Model
{
    protected $table = 'analisis_parque';

    protected $fillable = [
        'atraccion_id',
        'visita_id',
        'visitantes_registrados',
        'capacidad_maxima',
        'porcentaje_ocupacion',
        'nivel_demanda',
        'recomendacion',
    ];

    public function atraccion()
    {
        return $this->belongsTo(Atraccion::class);
    }

    public function visita()
    {
        return $this->belongsTo(Visita::class);
    }
}