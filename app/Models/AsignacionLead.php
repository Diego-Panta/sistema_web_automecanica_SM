<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AsignacionLead extends Model
{
    protected $table = 'asignaciones_leads';

    protected $fillable = [
        'lead_id',
        'usuario_asignador_id',
        'usuario_asignado_id',
        'fecha_asignacion',
        'observacion'
    ];

    protected $casts = [
        'fecha_asignacion' => 'datetime'
    ];

    public function lead(): BelongsTo
    {
        return $this->belongsTo(Lead::class);
    }

    public function asignador(): BelongsTo
    {
        return $this->belongsTo(User::class, 'usuario_asignador_id');
    }

    public function asignado(): BelongsTo
    {
        return $this->belongsTo(User::class, 'usuario_asignado_id');
    }
}
