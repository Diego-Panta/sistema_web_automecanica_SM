<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sede extends Model
{
    protected $fillable = [
        'codigo_sede',
        'nombre_sede',
        'ciudad',
        'direccion',
        'descripcion',
        'capacidad'
    ];
    
    public function usersLaborales()
    {
        return $this->hasMany(UserLaborale::class);
    }

    public function configuracionesAsignacion()
    {
        return $this->hasMany(ConfigAsignacione::class);
    }
}
