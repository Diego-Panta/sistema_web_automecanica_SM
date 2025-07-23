<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResultadoLead extends Model
{
    protected $fillable = ['nombre_resultado'];
    
    public function leads()
    {
        return $this->hasMany(Lead::class, 'resultado_id');
    }
}
