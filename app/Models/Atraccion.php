<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Atraccion extends Model
{
    protected $table = 'atracciones';

    protected $fillable = [
        'nombre',
        'tipo',
        'capacidad_hora',
        'estado',
    ];

    public function visitas()
    {
        return $this->hasMany(Visita::class);
    }

    public function analisis()
    {
        return $this->hasMany(AnalisisParque::class);
    }
}