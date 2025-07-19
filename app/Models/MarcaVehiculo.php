<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MarcaVehiculo extends Model
{
    public function modelos()
    {
        return $this->hasMany(ModeloVehiculo::class, 'marca_id');
    }
}
