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
        'forma_registro_id', 'modelo_id', 'tipo_servicio_id',
        'financiamiento', 'tiempo_compra', 'numero_placa', 'kilometraje',
        'fecha_cita', 'horario_cita', 'observacion', 'consulta', 'fecha_cierre'
    ];

    protected $casts = [
        'fecha_cita' => 'datetime',
        'fecha_cierre' => 'datetime',
        'financiamiento' => 'boolean',
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

    public function tipoServicio() { return $this->belongsTo(TipoServicio::class, 'tipo_servicio_id'); }
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

    // Métodos para determinar el tipo de lead
    public function isCompra()
    {
        return $this->tipo && in_array(strtolower($this->tipo->nombre_tipo), ['compra', 'cotización de auto (compra)']);
    }

    public function isPostventa()
    {
        return $this->tipo && in_array(strtolower($this->tipo->nombre_tipo), ['postventa', 'solicita tu servicio de mantenimiento (postventa)']);
    }

    public function isRepuesto()
    {
        return $this->tipo && in_array(strtolower($this->tipo->nombre_tipo), ['repuesto', '¡cotiza tu repuesto!']);
    }

    // Métodos para obtener campos específicos según el tipo
    public function getCamposEspecificos()
    {
        if ($this->isCompra()) {
            return [
                'tipo_documento' => $this->cliente->tipoDocumento->nombre ?? 'N/A',
                'marca' => $this->modeloVehiculo->marca->nombre_marca ?? 'N/A',
                'modelo' => $this->modeloVehiculo->nombre_modelo ?? 'N/A',
                'nombre' => $this->cliente->nombre ?? 'N/A',
                'apellidos' => trim($this->cliente->apellido_paterno . ' ' . ($this->cliente->apellido_materno ?? '')),
                'telefono' => $this->cliente->celular ?? 'N/A',
                'email' => $this->cliente->correo ?? 'N/A',
                'tiempo_compra' => $this->tiempo_compra ?? 'N/A',
                'forma_contacto' => $this->medioContacto->nombre_medio ?? 'N/A',
                'deseo_credito' => $this->financiamiento ? 'Sí' : 'No'
            ];
        } elseif ($this->isPostventa()) {
            return [
                'tipo_documento' => $this->cliente->tipoDocumento->nombre ?? 'N/A',
                'nombres_completos' => $this->cliente->nombre_completo ?? 'N/A',
                'telefono' => $this->cliente->celular ?? 'N/A',
                'email' => $this->cliente->correo ?? 'N/A',
                'marca' => $this->modeloVehiculo->marca->nombre_marca ?? 'N/A',
                'modelo' => $this->modeloVehiculo->nombre_modelo ?? 'N/A',
                'numero_placa' => $this->numero_placa ?? 'N/A',
                'kilometraje' => $this->kilometraje ?? 'N/A',
                'tipo_servicio' => $this->tipoServicio->nombre_tipo ?? 'N/A',
                'fecha_cita' => $this->fecha_cita ? $this->fecha_cita->format('d/m/Y') : 'N/A',
                'horario_cita' => $this->horario_cita ?? 'N/A',
                'consulta' => $this->consulta ?? $this->observacion ?? 'N/A'
            ];
        } elseif ($this->isRepuesto()) {
            return [
                'tipo_documento' => $this->cliente->tipoDocumento->nombre ?? 'N/A',
                'nombre' => $this->cliente->nombre ?? 'N/A',
                'apellido' => $this->cliente->apellido_paterno ?? 'N/A',
                'telefono' => $this->cliente->celular ?? 'N/A',
                'email' => $this->cliente->correo ?? 'N/A',
                'marca' => $this->modeloVehiculo->marca->nombre_marca ?? 'N/A',
                'modelo' => $this->modeloVehiculo->nombre_modelo ?? 'N/A',
                'numero_placa' => $this->numero_placa ?? 'N/A',
                'consulta' => $this->consulta ?? $this->observacion ?? 'N/A'
            ];
        }

        return [];
    }
}
