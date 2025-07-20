<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Turno extends Model
{
    protected $fillable = ['nombre_turno', 'hora_inicio', 'hora_fin'];
    
    public function usersLaborales()
    {
        return $this->hasMany(UserLaborale::class);
    }
}
