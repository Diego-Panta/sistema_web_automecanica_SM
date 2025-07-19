<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccionRealizada extends Model
{
    protected $table = 'acciones_realizadas';
    
    public function accion()
    {
        return $this->belongsTo(Accione::class, 'accion_id');
    }
    
    public function lead()
    {
        return $this->belongsTo(Lead::class);
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
