<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EstadoUsuario extends Model
{
    public function usersLaborales()
    {
        return $this->hasMany(UserLaborale::class, 'estado_usuario_id');
    }
}
