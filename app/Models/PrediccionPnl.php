<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrediccionPnl extends Model
{
    protected $table = 'predicciones_pnl';

    public function lead()
    {
        return $this->belongsTo(Lead::class);
    }
}
