<?php

namespace App\Services;

use App\Models\Lead;
use App\Models\TipoLead;
use App\Models\EstadoLead;
use App\Models\User;
use App\Models\Sede;
use App\Models\AsignacionLead;
use Illuminate\Support\Facades\DB;

class AsignacionLeadService
{
    public function getAvailableAdvisors(Lead $lead, User $marketingUser)
    {
        // Verificar que el lead tenga una sede asignada
        if (!$lead->sede_id) {
            return collect();
        }

        // Obtener el tipo de lead
        $leadType = $lead->tipo;

        if (!$leadType) {
            return collect();
        }

        // Obtener roles permitidos según el tipo de lead
        $allowedRoles = $this->getAllowedRoles($leadType->nombre_tipo);

        if (empty($allowedRoles)) {
            return collect();
        }

        // Obtener asesores disponibles de la misma sede y con los roles permitidos
        return User::whereHas('roles', function ($query) use ($allowedRoles) {
            $query->whereIn('name', $allowedRoles);
        })
            ->whereHas('laborale', function ($query) use ($lead) {
                $query->where('sede_id', $lead->sede_id)
                    ->whereHas('estado', function ($q) {
                        $q->where('nombre_estado', 'Activo');
                    });
            })
            ->with(['laborale', 'roles'])
            ->get();
    }

    private function getAllowedRoles($leadTypeName)
    {
        $mapping = [
            'Compra' => ['asesor ventas'],
            'Postventa' => ['jefe postventa'],
            'Repuesto' => ['jefe repuestos'],
            'Cotización de auto (compra)' => ['asesor ventas'],
            'Solicita tu servicio de mantenimiento (postventa)' => ['jefe postventa'],
            '¡Cotiza tu repuesto!' => ['jefe repuestos']
        ];

        // Buscar coincidencia exacta
        if (isset($mapping[$leadTypeName])) {
            return $mapping[$leadTypeName];
        }

        // Buscar coincidencia parcial
        foreach ($mapping as $key => $roles) {
            if (str_contains(strtolower($leadTypeName), strtolower($key))) {
                return $roles;
            }
        }

        return [];
    }

    public function canMarketingUserAssign(User $marketingUser, Lead $lead)
    {
        // Verificar que el usuario tenga rol de marketing
        if (!$marketingUser->hasRole('marketing')) {
            return false;
        }

        // Verificar que el usuario tenga datos laborales
        if (!$marketingUser->laborale) {
            return false;
        }

        // Verificar que el marketing user tenga acceso a la sede del lead
        return $marketingUser->laborale->sede_id === $lead->sede_id;
    }

    public function assignLead(Lead $lead, User $assignedUser, User $assignerUser, $observation = null)
    {
        return DB::transaction(function () use ($lead, $assignedUser, $assignerUser, $observation) {
            // CORRECCIÓN: Primero verificar que no exista una asignación activa
            $asignacionExistente = AsignacionLead::where('lead_id', $lead->id)
                ->where('activo', true)
                ->first();

            if ($asignacionExistente) {
                throw new \Exception('El lead ya tiene una asignación activa.');
            }

            // Crear la nueva asignación
            $assignment = AsignacionLead::create([
                'lead_id' => $lead->id,
                'usuario_asignador_id' => $assignerUser->id,
                'usuario_asignado_id' => $assignedUser->id,
                'observacion' => $observation,
                'fecha_asignacion' => now(),
                'activo' => true
            ]);

            // Actualizar el estado del lead
            $estadoAsignado = EstadoLead::where('nombre_estado', 'Asignado')->first();
            if ($estadoAsignado) {
                $lead->update([
                    'estado_actual_id' => $estadoAsignado->id
                ]);
            }

            return $assignment;
        });
    }

    public function getAssignmentHistory($filters = [], $userSedes = [])
    {
        $query = AsignacionLead::with([
            'lead',
            'asignador',
            'asignado',
            'lead.tipo',
            'lead.sede'
        ]);

        // Filtrar por sedes del usuario si se proporcionan
        if (!empty($userSedes)) {
            $query->whereHas('lead', function ($q) use ($userSedes) {
                $q->whereIn('sede_id', $userSedes);
            });
        }

        if (!empty($filters['fecha_inicio'])) {
            $query->whereDate('fecha_asignacion', '>=', $filters['fecha_inicio']);
        }

        if (!empty($filters['fecha_fin'])) {
            $query->whereDate('fecha_asignacion', '<=', $filters['fecha_fin']);
        }

        if (!empty($filters['tipo_lead_id'])) {
            $query->whereHas('lead', function ($q) use ($filters) {
                $q->where('tipo_id', $filters['tipo_lead_id']);
            });
        }

        if (!empty($filters['usuario_asignado_id'])) {
            $query->where('usuario_asignado_id', $filters['usuario_asignado_id']);
        }

        return $query->orderBy('fecha_asignacion', 'desc')->paginate(20);
    }
}
