<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserHorario extends Model
{
    protected $table = 'user_horarios';

    protected $fillable = ['user_laborale_id', 'dia_semana', 'turno_id'];

    public function empleado()
    {
        return $this->belongsTo(UserLaborale::class, 'user_laborale_id');
    }

    public function turno()
    {
        return $this->belongsTo(Turno::class, 'turno_id');
    }

    // OPCIONAL: Si quieres mantener acceso a la sede desde el horario
    // pero con manejo de null
    public function sede()
    {
        if ($this->empleado) {
            return $this->empleado->sede();
        }
        return null;
    }
    
    // O mejor aún: usar accessor para evitar problemas
    public function getSedeAttribute()
    {
        return $this->empleado ? $this->empleado->sede : null;
    }
}