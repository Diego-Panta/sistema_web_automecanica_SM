<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormaRegistro extends Model
{
    public function leads()
    {
        return $this->hasMany(Lead::class, 'forma_registro_id');
    }
}
