<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserHorario extends Model
{
    protected $table = 'user_horarios';

    protected $fillable = ['user_laborale_id', 'sede_id', 'dia_semana', 'turno_id'];

    public function empleado()
    {
        return $this->belongsTo(User::class, 'user_laborale_id');
    }

    public function sede()
    {
        return $this->belongsTo(Sede::class, 'sede_id');
    }

    public function turno()
    {
        return $this->belongsTo(Turno::class, 'turno_id');
    }
}
