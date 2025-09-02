<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserLaborale extends Model
{
    protected $table = 'user_laborales';

    protected $fillable = [
        'user_id',
        'estado_user_id',
        'sede_id', // AGREGADO
        'codigo_trabajador',
        'fecha_contratacion_inicio',
        'fecha_contratacion_fin',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function sede()
    {
        return $this->belongsTo(Sede::class, 'sede_id'); // NUEVA RELACIÓN
    }

    public function horarios()
    {
        return $this->hasMany(UserHorario::class, 'user_laborale_id');
    }

    public function estado()
    {
        return $this->belongsTo(EstadoUser::class, 'estado_user_id');
    }

    // Método helper para obtener todas las sedes asignadas
    public function sedes()
    {
        return $this->belongsToMany(Sede::class, 'user_horarios', 'user_laborale_id', 'sede_id')->distinct();
    }

    // Método helper para obtener todos los turnos asignados
    public function turnos()
    {
        return $this->belongsToMany(Turno::class, 'user_horarios', 'user_laborale_id', 'turno_id')->distinct();
    }

    // Método helper para obtener horarios agrupados por sede
    public function horariosPorSede()
    {
        return $this->horarios()->with(['sede', 'turno'])->get()->groupBy('sede_id');
    }

    // Método helper para obtener horarios de un día específico
    public function horariosPorDia($dia)
    {
        return $this->horarios()->where('dia_semana', $dia)->with(['sede', 'turno'])->get();
    }
}
