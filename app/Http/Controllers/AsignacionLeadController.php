<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\User;
use App\Models\TipoLead;
use Illuminate\Http\Request;
use App\Services\AsignacionLeadService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class AsignacionLeadController extends Controller
{
    protected $assignmentService;

    public function __construct(AsignacionLeadService $assignmentService)
    {
        $this->middleware('can:gestionar_leads');
        $this->assignmentService = $assignmentService;
    }

    public function index()
    {
        $leads = Lead::whereDoesntHave('asignaciones')
            ->orWhereHas('asignaciones', function ($query) {
                $query->where('fecha_asignacion', '<', now()->subDays(7));
            })
            ->with(['cliente', 'tipo', 'estadoActual'])
            ->paginate(15);

        return view('leads.asignaciones.index', compact('leads'));
    }

    public function create(Request $request)
    {
        $lead = null;
        $availableAdvisors = collect();

        if ($request->has('lead_id')) {
            $lead = Lead::with(['cliente', 'tipo'])->findOrFail($request->lead_id);
            $availableAdvisors = $this->assignmentService->getAvailableAdvisors($lead, Auth::user());
        }

        $leads = Lead::whereDoesntHave('asignaciones')
            ->with(['cliente', 'tipo'])
            ->get();

        return view('leads.asignaciones.create', compact('leads', 'lead', 'availableAdvisors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'lead_id' => 'required|exists:leads,id',
            'usuario_asignado_id' => 'required|exists:users,id',
            'observacion' => 'nullable|string|max:500'
        ]);

        $lead = Lead::findOrFail($request->lead_id);
        $assignedUser = User::findOrFail($request->usuario_asignado_id);

        try {
            $assignment = $this->assignmentService->assignLead(
                $lead,
                $assignedUser,
                Auth::user(),
                $request->observacion
            );

            return redirect()->route('leads.assign')
                ->with('success', 'Lead asignado correctamente.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error al asignar el lead: ' . $e->getMessage());
        }
    }

    public function edit(Lead $lead)
    {
        $availableAdvisors = $this->assignmentService->getAvailableAdvisors($lead, Auth::user());
        $currentAssignment = $lead->asignaciones()->latest()->first();

        return view('leads.asignaciones.edit', compact('lead', 'availableAdvisors', 'currentAssignment'));
    }

    public function update(Request $request, Lead $lead)
    {
        $request->validate([
            'usuario_asignado_id' => 'required|exists:users,id',
            'observacion' => 'nullable|string|max:500'
        ]);

        $assignedUser = User::findOrFail($request->usuario_asignado_id);

        try {
            // Primero, marcar la asignación anterior como inactiva si existe
            $lead->asignaciones()->update(['activo' => false]);

            // Crear nueva asignación
            $assignment = $this->assignmentService->assignLead(
                $lead,
                $assignedUser,
                Auth::user(),
                $request->observacion
            );

            return redirect()->route('leads.assign.history')
                ->with('success', 'Asignación actualizada correctamente.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error al actualizar la asignación: ' . $e->getMessage());
        }
    }

    public function history(Request $request)
    {
        $filters = $request->only(['fecha_inicio', 'fecha_fin', 'tipo_lead_id', 'usuario_asignado_id']);
        $assignments = $this->assignmentService->getAssignmentHistory($filters);

        $tiposLead = TipoLead::all();
        $asesores = User::whereHas('roles', function ($query) {
            $query->whereIn('name', ['asesor ventas', 'jefe postventa', 'jefe repuestos']);
        })->get();

        return view('leads.asignaciones.history', compact('assignments', 'tiposLead', 'asesores', 'filters'));
    }
}
