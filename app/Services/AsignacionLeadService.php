<?php

namespace App\Services;

use App\Models\Lead;
use App\Models\TipoLead;
use App\Models\EstadoLead;
use App\Models\User;
use App\Models\Sede;
use App\Models\ConfigAsignacion;
use App\Models\AsignacionLead;
use Illuminate\Support\Facades\DB;

class AsignacionLeadService
{
    public function getAvailableAdvisors(Lead $lead, User $marketingUser)
    {
        // Obtener sedes compartidas entre el usuario de marketing y los asesores
        $sharedSedes = $this->getSharedSedes($marketingUser);
        
        if ($sharedSedes->isEmpty()) {
            return collect();
        }

        // Obtener tipo de lead
        $leadType = $lead->tipo_id;
        
        // Obtener roles permitidos según el tipo de lead
        $allowedRoles = $this->getAllowedRoles($leadType);
        
        // Obtener asesores disponibles
        return User::whereHas('roles', function($query) use ($allowedRoles) {
                $query->whereIn('name', $allowedRoles);
            })
            ->whereHas('laboral.sedes', function($query) use ($sharedSedes) {
                $query->whereIn('sedes.id', $sharedSedes->pluck('id'));
            })
            ->whereHas('laboral.estado', function($query) {
                $query->where('nombre_estado', 'Activo');
            })
            ->with(['laboral', 'roles'])
            ->get()
            ->filter(function($user) use ($leadType) {
                return $this->canHandleLeadType($user, $leadType);
            });
    }

    private function getSharedSedes(User $marketingUser)
    {
        $marketingSedes = $marketingUser->laboral->sedes ?? collect();
        
        return Sede::whereIn('id', $marketingSedes->pluck('id'))->get();
    }

    private function getAllowedRoles($leadType)
    {
        $mapping = [
            'Compra' => ['asesor ventas'],
            'Postventa' => ['jefe postventa'],
            'Repuesto' => ['jefe repuestos']
        ];

        $tipoLead = TipoLead::find($leadType);
        
        return $mapping[$tipoLead->nombre_tipo] ?? [];
    }

    private function canHandleLeadType(User $user, $leadType)
    {
        $tipoLead = TipoLead::find($leadType);
        
        $roleLeadMapping = [
            'asesor ventas' => 'Compra',
            'jefe postventa' => 'Postventa',
            'jefe repuestos' => 'Repuesto'
        ];

        $userRole = $user->roles->first()->name;
        
        return $roleLeadMapping[$userRole] === $tipoLead->nombre_tipo;
    }

    public function assignLead(Lead $lead, User $assignedUser, User $assignerUser, $observation = null)
    {
        return DB::transaction(function() use ($lead, $assignedUser, $assignerUser, $observation) {
            // Crear la asignación
            $assignment = AsignacionLead::create([
                'lead_id' => $lead->id,
                'usuario_asignador_id' => $assignerUser->id,
                'usuario_asignado_id' => $assignedUser->id,
                'observacion' => $observation,
                'fecha_asignacion' => now()
            ]);

            // Actualizar el estado del lead si es necesario
            $lead->update([
                'estado_actual_id' => EstadoLead::where('nombre_estado', 'Asignado')->first()->id
            ]);

            return $assignment;
        });
    }

    public function getAssignmentHistory($filters = [])
    {
        $query = AsignacionLead::with(['lead', 'asignador', 'asignado', 'lead.tipo']);
        
        if (!empty($filters['fecha_inicio'])) {
            $query->whereDate('fecha_asignacion', '>=', $filters['fecha_inicio']);
        }
        
        if (!empty($filters['fecha_fin'])) {
            $query->whereDate('fecha_asignacion', '<=', $filters['fecha_fin']);
        }
        
        if (!empty($filters['tipo_lead_id'])) {
            $query->whereHas('lead', function($q) use ($filters) {
                $q->where('tipo_id', $filters['tipo_lead_id']);
            });
        }
        
        if (!empty($filters['usuario_asignado_id'])) {
            $query->where('usuario_asignado_id', $filters['usuario_asignado_id']);
        }

        return $query->orderBy('fecha_asignacion', 'desc')->paginate(20);
    }
}