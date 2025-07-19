<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HistorialEstado extends Model
{
    protected $table = 'historial_estados';
    
    // Ya no es clave compuesta
    protected $primaryKey = 'id';
    public $incrementing = true;

    protected $fillable = ['lead_id', 'estado_id', 'user_id', 'fecha_cambio'];

    public function lead()
    {
        return $this->belongsTo(Lead::class);
    }

    public function estado()
    {
        return $this->belongsTo(EstadoLead::class, 'estado_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
