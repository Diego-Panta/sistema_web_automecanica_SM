<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CargaTrabajo extends Model
{
    protected $table = 'cargas_trabajo';

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
