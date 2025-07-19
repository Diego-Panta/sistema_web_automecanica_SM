<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sede extends Model
{
    public function usersLaborales()
    {
        return $this->hasMany(UserLaborale::class);
    }

    public function configuracionesAsignacion()
    {
        return $this->hasMany(ConfigAsignacione::class);
    }
}
