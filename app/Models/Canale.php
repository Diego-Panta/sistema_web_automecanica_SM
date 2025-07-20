<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Canale extends Model
{
    protected $fillable = ['nombre_canal'];
    
    public function leads()
    {
        return $this->hasMany(Lead::class);
    }
}
