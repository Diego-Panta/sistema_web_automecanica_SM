<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserLaborale extends Model
{
    protected $table = 'user_laboral';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function sede()
    {
        return $this->belongsTo(Sede::class);
    }

    public function turno()
    {
        return $this->belongsTo(Turno::class);
    }

    public function estado()
    {
        return $this->belongsTo(EstadoUser::class, 'estado_user_id');
    }
}
