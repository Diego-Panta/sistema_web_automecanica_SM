<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cliente extends Model
{
    use SoftDeletes;

    public function estado()
    {
        return $this->belongsTo(EstadoCliente::class, 'estado_cliente_id');
    }

    public function leads()
    {
        return $this->hasMany(Lead::class);
    }
}
