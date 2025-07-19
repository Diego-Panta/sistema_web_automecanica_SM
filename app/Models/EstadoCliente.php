<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EstadoCliente extends Model
{
    protected $fillable = ['nombre_estado'];
    
    public function clientes()
    {
        return $this->hasMany(Cliente::class, 'estado_cliente_id');
    }
}
