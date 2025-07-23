<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModeloVehiculo extends Model
{
    protected $fillable = ['marca_id', 'tipo_id', 'nombre_modelo'];
    
    public function marca()
    {
        return $this->belongsTo(MarcaVehiculo::class, 'marca_id');
    }

    public function tipo()
    {
        return $this->belongsTo(TipoVehiculo::class, 'tipo_id');
    }

    public function leads()
    {
        return $this->hasMany(Lead::class, 'modelo_id');
    }
}
