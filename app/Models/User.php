<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

 
class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name', 'email', 'password', 'dni', 'celular', 
        'celular_alterno', 'email_personal', 'fecha_nacimiento', 'direccion'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];


    // 1:1 con UserLaboral
    public function laborale()
    {
        return $this->hasOne(UserLaborale::class);
    }

    // Leads creados por este usuario
    public function leadCreados()
    {
        return $this->hasMany(Lead::class, 'usuario_creador_id');
    }

    // RELACIONES ACTUALIZADAS CON NUEVOS MODELOS PIVOTE:
    
    // Leads asignados (como asignado) - ahora usando AsignacionLead
    public function asignacionesRecibidas()
    {
        return $this->hasMany(AsignacionLead::class, 'usuario_asignado_id');
    }

    // Leads asignados (como asignador) - ahora usando AsignacionLead
    public function asignacionesRealizadas()
    {
        return $this->hasMany(AsignacionLead::class, 'usuario_asignador_id');
    }

    // Relación con el historial de cambios de estado
    public function historialCambiosEstado()
    {
        return $this->hasMany(HistorialEstado::class, 'user_id');
    }

    // Acciones realizadas - ahora usando AccionRealizada
    public function accionesRealizadas()
    {
        return $this->hasMany(AccionRealizada::class);
    }

    // Carga de trabajo
    public function cargaTrabajo()
    {
        return $this->hasOne(CargaTrabajo::class);
    }

    // Relación con estados a través del historial (Opcional - puedes mantenerla o eliminar)
    public function estadosLead()
    {
        return $this->belongsToMany(EstadoLead::class, 'historial_estados', 'user_id', 'estado_id')
            ->withPivot(['lead_id', 'fecha_cambio']);
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
