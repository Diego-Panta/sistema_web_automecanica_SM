<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EstadoUser extends Model
{
    protected $fillable = ['nombre_estado'];
    
    public function usersLaborales()
    {
        return $this->hasMany(UserLaborale::class, 'estado_user_id');
    }
}
