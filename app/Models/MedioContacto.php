<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MedioContacto extends Model
{
    protected $fillable = ['nombre_medio', 'descripcion'];
    
    public function leads()
    {
        return $this->hasMany(Lead::class, 'medio_contacto_id');
    }
}
