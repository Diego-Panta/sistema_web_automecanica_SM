<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EstadoLead extends Model
{
    public function leadsActuales()
    {
        return $this->hasMany(Lead::class, 'estado_actual_id');
    }

    public function historiales()
    {
        return $this->hasMany(HistorialEstado::class, 'estado_id');
    }

    // Relación con usuarios a través del historial (Opcional)
    public function users()
    {
        return $this->belongsToMany(User::class, 'historial_estados', 'estado_id', 'user_id')
            ->withPivot(['lead_id', 'fecha_cambio']);
    }
}
