<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sede extends Model
{
    protected $fillable = [
        'codigo_sede',
        'nombre_sede',
        'ciudad_id',
        'direccion',
        'descripcion',
        'capacidad'
    ];
    
    public function horarios()
    {
        return $this->hasMany(UserHorario::class, 'sede_id');
    }

    public function configuracionesAsignacion()
    {
        return $this->hasMany(ConfigAsignacione::class);
    }

    public function ciudad()
    {
        return $this->belongsTo(Ciudade::class, 'ciudad_id');
    }

}
