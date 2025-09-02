<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ConfigAsignacione extends Model
{
    protected $table = 'config_asignaciones';

    protected $fillable = [
        'tipo_lead_id',
        'sede_id',
        'max_leads_por_asesor',
        'prioridad_rotacion'
    ];

    public function tipoLead(): BelongsTo
    {
        return $this->belongsTo(TipoLead::class);
    }

    public function sede(): BelongsTo
    {
        return $this->belongsTo(Sede::class);
    }
}
