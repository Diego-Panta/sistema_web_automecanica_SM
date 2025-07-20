<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sede extends Model
{
    protected $fillable = ['nombre_sede', 'direccion', 'capacidad'];
    
    public function usersLaborales()
    {
        return $this->hasMany(UserLaborale::class);
    }

    public function configuracionesAsignacion()
    {
        return $this->hasMany(ConfigAsignacione::class);
    }

    public function direcciones()
    {
        return $this->hasMany(Direccione::class);
    }

}
