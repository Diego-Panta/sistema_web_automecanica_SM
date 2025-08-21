<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Turno extends Model
{
    protected $fillable = ['nombre_turno', 'hora_inicio', 'hora_fin'];

    // Relación muchos a muchos con UserLaborale
    public function horarios()
    {
        return $this->hasMany(UserHorario::class, 'turno_id');
    }
}
