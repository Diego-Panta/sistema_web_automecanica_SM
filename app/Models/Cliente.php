<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cliente extends Model
{
    protected $fillable = [
        'estado_cliente_id',
        'nombre',
        'apellido_paterno',
        'apellido_materno',
        'dni',
        'celular',
        'celular_alterno',
        'correo'
    ];

    use SoftDeletes;

    public function estado()
    {
        return $this->belongsTo(EstadoCliente::class, 'estado_cliente_id');
    }

    public function leads()
    {
        return $this->hasMany(Lead::class);
    }

    public function getNombreCompletoAttribute()
    {
        return trim("{$this->nombre} {$this->apellido_paterno} {$this->apellido_materno}");
    }
}
