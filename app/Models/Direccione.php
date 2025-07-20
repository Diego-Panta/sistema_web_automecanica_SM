<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Direccione extends Model
{
    public function sede()
    {
        return $this->belongsTo(Sede::class);
    }
}
