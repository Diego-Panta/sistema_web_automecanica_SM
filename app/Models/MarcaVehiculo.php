<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MarcaVehiculo extends Model
{
    protected $fillable = ['nombre_marca'];
    
    public function modelos()
    {
        return $this->hasMany(ModeloVehiculo::class, 'marca_id');
    }
}
