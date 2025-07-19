<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConfigAsignacione extends Model
{
    protected $table = 'config_asignaciones';

    public function tipoLead()
    {
        return $this->belongsTo(TipoLead::class, 'tipo_lead_id');
    }

    public function sede()
    {
        return $this->belongsTo(Sede::class, 'sede_id');
    }
}
