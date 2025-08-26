<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoServicio extends Model
{
    
    protected $fillable = [
        'nombre',
        'descripcion'
    ];

    public function leads()
    {
        return $this->hasMany(Lead::class);
    }
}
