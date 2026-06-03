<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Visita extends Model
{
    protected $table = 'visitas';

    protected $fillable = [
        'user_id',
        'atraccion_id',
        'fecha',
        'hora_inicio',
        'hora_fin',
        'cantidad_visitantes',
        'promocion_activa',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function atraccion()
    {
        return $this->belongsTo(Atraccion::class);
    }

    public function analisis()
    {
        return $this->hasOne(AnalisisParque::class);
    }
}