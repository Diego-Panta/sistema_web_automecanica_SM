<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoVehiculo extends Model
{
    public function modelos()
    {
        return $this->hasMany(ModeloVehiculo::class, 'tipo_id');
    }
}
