<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lead extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'cliente_id', 'canal_id', 'tipo_id', 'estado_actual_id',
        'resultado_id', 'usuario_creador_id', 'medio_contacto_id',
        'forma_registro_id', 'modelo_id', 'financiamiento',
        'tiempo_compra', 'observacion', 'fecha_cierre'
    ];

    // Relaciones belongsTo
    public function cliente() { return $this->belongsTo(Cliente::class); }
    public function canal() { return $this->belongsTo(Canale::class); }
    public function tipo() { return $this->belongsTo(TipoLead::class, 'tipo_id'); }
    public function estadoActual() { return $this->belongsTo(EstadoLead::class, 'estado_actual_id'); }
    public function resultado() { return $this->belongsTo(ResultadoLead::class, 'resultado_id'); }
    public function creador() { return $this->belongsTo(User::class, 'usuario_creador_id'); }
    public function medioContacto() { return $this->belongsTo(MedioContacto::class, 'medio_contacto_id'); }
    public function formaRegistro() { return $this->belongsTo(FormaRegistro::class, 'forma_registro_id'); }
    public function modeloVehiculo() { return $this->belongsTo(ModeloVehiculo::class, 'modelo_id'); }

    // RELACIONES ACTUALIZADAS:
    
    // Historial de estados
    public function historialEstados()
    {
        return $this->hasMany(HistorialEstado::class);
    }

    // Asignaciones
    public function asignaciones()
    {
        return $this->hasMany(AsignacionLead::class);
    }

    // Acciones realizadas
    public function accionesRealizadas()
    {
        return $this->hasMany(AccionRealizada::class);
    }

    // Relaciones many-to-many (puedes mantenerlas como atajos)
    public function usuariosAsignados()
    {
        return $this->belongsToMany(User::class, 'asignaciones_lead', 'lead_id', 'usuario_asignado_id')
            ->using(AsignacionLead::class)
            ->withPivot(['usuario_asignador_id', 'fecha_asignacion', 'observacion']);
    }

    public function acciones()
    {
        return $this->belongsToMany(Accione::class, 'acciones_realizadas', 'lead_id', 'accion_id')
            ->using(AccionRealizada::class)
            ->withPivot(['user_id', 'comentario', 'fecha']);
    }

    // Relaciones hasMany
    public function prediccionesPnl()
    {
        return $this->hasMany(PrediccionPnl::class);
    }

}
