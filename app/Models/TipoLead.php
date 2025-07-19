<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoLead extends Model
{
    protected $fillable = ['nombre_tipo'];
    
    public function leads()
    {
        return $this->hasMany(Lead::class, 'tipo_id');
    }

    public function configuracionesAsignacion()
    {
        return $this->hasMany(ConfigAsignacione::class, 'tipo_lead_id');
    }
}
