<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Turno extends Model
{
    public function usersLaborales()
    {
        return $this->hasMany(UserLaborale::class);
    }
}
