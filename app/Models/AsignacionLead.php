<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AsignacionLead extends Model
{
    protected $table = 'asignaciones_lead';
    
    public function lead()
    {
        return $this->belongsTo(Lead::class);
    }
    
    public function asignador()
    {
        return $this->belongsTo(User::class, 'usuario_asignador_id');
    }
    
    public function asignado()
    {
        return $this->belongsTo(User::class, 'usuario_asignado_id');
    }
}
