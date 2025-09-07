<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\User;
use App\Models\TipoLead;
use App\Models\AsignacionLead;
use App\Models\EstadoLead;
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
        $this->middleware('can:asignar_leads');
        $this->assignmentService = $assignmentService;
    }

    public function index()
    {
        try {
            $user = Auth::user();

            // Verificar que el usuario tenga datos laborales y sea de marketing
            if (!$user->laborale || !$this->userHasMarketingRole($user)) {
                $leads = collect();
                $errorMessage = "No tienes permisos para asignar leads o no tienes datos laborales configurados.";
                return view('leads.asignaciones.index', compact('leads', 'errorMessage'));
            }

            // CORRECCIÓN: Solo mostrar leads que NO tengan asignaciones activas
            $leads = Lead::where('sede_id', $user->laborale->sede_id)
                ->whereDoesntHave('asignaciones', function ($query) {
                    $query->where('activo', true);
                })
                ->with(['cliente', 'tipo', 'estadoActual', 'sede'])
                ->paginate(15);

            return view('leads.asignaciones.index', compact('leads'));
        } catch (Throwable $e) {
            Log::error("Error en index de asignación de leads", ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return redirect()->route('leads.assign')
                ->with('error', 'Error al cargar la lista de leads: ' . $e->getMessage());
        }
    }

    public function create(Request $request)
    {
        try {
            $user = Auth::user();
            $lead = null;
            $availableAdvisors = collect();
            $errorMessage = null;

            // Verificar que el usuario tenga datos laborales y sea de marketing
            if (!$user->laborale || !$this->userHasMarketingRole($user)) {
                $errorMessage = "No tienes permisos para asignar leads o no tienes datos laborales configurados.";
                $leads = collect();
                return view('leads.asignaciones.create', compact('leads', 'lead', 'availableAdvisors', 'errorMessage'));
            }

            if ($request->has('lead_id')) {
                $lead = Lead::with(['cliente', 'tipo', 'sede'])->findOrFail($request->lead_id);

                // Verificar que el lead sea de la misma sede que el usuario
                if ($lead->sede_id !== $user->laborale->sede_id) {
                    $errorMessage = "No tienes permisos para asignar leads de esta sede.";
                } else {
                    // CORRECCIÓN: Verificar que el lead no tenga asignaciones activas
                    $tieneAsignacionActiva = $lead->asignaciones()->where('activo', true)->exists();

                    if ($tieneAsignacionActiva) {
                        $errorMessage = "Este lead ya tiene una asignación activa.";
                    } else {
                        $availableAdvisors = $this->assignmentService->getAvailableAdvisors($lead, $user);

                        if ($availableAdvisors->isEmpty()) {
                            $errorMessage = 'No hay asesores disponibles para este tipo de lead en la sede ' . $lead->sede->nombre_sede;
                        }
                    }
                }
            }

            // CORRECCIÓN: Solo mostrar leads que NO tengan asignaciones activas
            $leads = Lead::where('sede_id', $user->laborale->sede_id)
                ->whereDoesntHave('asignaciones', function ($query) {
                    $query->where('activo', true);
                })
                ->with(['cliente', 'tipo', 'sede'])
                ->get();

            return view('leads.asignaciones.create', compact('leads', 'lead', 'availableAdvisors', 'errorMessage'));
        } catch (Throwable $e) {
            Log::error("Error en create de asignación de leads", ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return redirect()->route('leads.assign')
                ->with('error', 'Error al cargar el formulario de asignación: ' . $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'lead_id' => 'required|exists:leads,id',
            'usuario_asignado_id' => 'required|exists:users,id',
            'observacion' => 'nullable|string|max:500'
        ]);

        try {
            DB::beginTransaction();

            $user = Auth::user();
            $lead = Lead::with('sede')->findOrFail($request->lead_id);
            $assignedUser = User::findOrFail($request->usuario_asignado_id);

            // Verificar permisos
            if (!$user->laborale || !$this->userHasMarketingRole($user)) {
                throw new \Exception('No tienes permisos para asignar leads.');
            }

            // Verificar que el lead sea de la misma sede
            if ($lead->sede_id !== $user->laborale->sede_id) {
                throw new \Exception('No tienes permisos para asignar leads de esta sede.');
            }

            // CORRECCIÓN: Verificar que el lead no tenga asignaciones activas
            $tieneAsignacionActiva = $lead->asignaciones()->where('activo', true)->exists();
            if ($tieneAsignacionActiva) {
                throw new \Exception('Este lead ya tiene una asignación activa.');
            }

            $assignment = $this->assignmentService->assignLead(
                $lead,
                $assignedUser,
                $user,
                $request->observacion
            );

            DB::commit();

            return redirect()->route('leads.assign')
                ->with('success', 'Lead asignado correctamente al asesor.');
        } catch (Throwable $e) {
            DB::rollBack();
            Log::error("Error al asignar lead", [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'lead_id' => $request->lead_id,
                'usuario_asignado_id' => $request->usuario_asignado_id
            ]);
            return back()->with('error', 'Error al asignar el lead: ' . $e->getMessage())->withInput();
        }
    }

    public function edit(Lead $lead)
    {
        try {
            $user = Auth::user();

            // Verificar permisos
            if (!$user->laborale || !$this->userHasMarketingRole($user) || $lead->sede_id !== $user->laborale->sede_id) {
                return redirect()->route('leads.assign')
                    ->with('error', 'No tienes permisos para editar esta asignación.');
            }

            $availableAdvisors = $this->assignmentService->getAvailableAdvisors($lead, $user);
            $currentAssignment = $lead->asignaciones()->where('activo', true)->first();

            return view('leads.asignaciones.edit', compact('lead', 'availableAdvisors', 'currentAssignment'));
        } catch (Throwable $e) {
            Log::error("Error en edit de asignación de leads", [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'lead_id' => $lead->id
            ]);
            return redirect()->route('leads.assign')
                ->with('error', 'Error al cargar el formulario de edición: ' . $e->getMessage());
        }
    }

    public function update(Request $request, Lead $lead)
    {
        $request->validate([
            'usuario_asignado_id' => 'required|exists:users,id',
            'observacion' => 'nullable|string|max:500'
        ]);

        try {
            DB::beginTransaction();

            $user = Auth::user();
            $assignedUser = User::findOrFail($request->usuario_asignado_id);

            // Verificar permisos
            if (!$user->laborale || !$this->userHasMarketingRole($user) || $lead->sede_id !== $user->laborale->sede_id) {
                throw new \Exception('No tienes permisos para editar esta asignación.');
            }

            $assignment = $this->assignmentService->assignLead(
                $lead,
                $assignedUser,
                $user,
                $request->observacion
            );

            DB::commit();

            return redirect()->route('leads.assign.history')
                ->with('success', 'Asignación actualizada correctamente.');
        } catch (Throwable $e) {
            DB::rollBack();
            Log::error("Error al actualizar asignación de lead", [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'lead_id' => $lead->id,
                'usuario_asignado_id' => $request->usuario_asignado_id
            ]);
            return back()->with('error', 'Error al actualizar la asignación: ' . $e->getMessage())->withInput();
        }
    }

    public function history(Request $request)
    {
        try {
            $user = Auth::user();

            // Verificar que el usuario tenga datos laborales
            if (!$user->laborale) {
                $assignments = collect();
                $errorMessage = "No tienes datos laborales configurados.";
                $tiposLead = TipoLead::all();
                $asesores = collect();
                return view('leads.asignaciones.history', compact('assignments', 'tiposLead', 'asesores', 'filters', 'errorMessage'));
            }

            $filters = $request->only(['fecha_inicio', 'fecha_fin', 'tipo_lead_id', 'usuario_asignado_id']);

            // Solo mostrar historial de la misma sede
            $assignments = AsignacionLead::whereHas('lead', function ($query) use ($user) {
                $query->where('sede_id', $user->laborale->sede_id);
            })
                ->with(['lead', 'asignador', 'asignado', 'lead.tipo', 'lead.sede'])
                ->orderBy('fecha_asignacion', 'desc')
                ->paginate(20);

            $tiposLead = TipoLead::all();
            $asesores = User::whereHas('roles', function ($query) {
                $query->whereIn('name', ['asesor ventas', 'jefe postventa', 'jefe repuestos']);
            })->get();

            return view('leads.asignaciones.history', compact('assignments', 'tiposLead', 'asesores', 'filters'));
        } catch (Throwable $e) {
            Log::error("Error en history de asignación de leads", ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return redirect()->route('leads.assign')
                ->with('error', 'Error al cargar el historial de asignaciones: ' . $e->getMessage());
        }
    }

    public function destroy(AsignacionLead $assignment)
    {
        try {
            DB::beginTransaction();

            $user = Auth::user();

            // Verificar permisos
            if (!$user->laborale || !$this->userHasMarketingRole($user)) {
                throw new \Exception('No tienes permisos para cancelar asignaciones.');
            }

            // Verificar que la asignación sea de la misma sede que el usuario
            if ($assignment->lead->sede_id !== $user->laborale->sede_id) {
                throw new \Exception('No tienes permisos para cancelar asignaciones de esta sede.');
            }

            // Verificar que la asignación esté activa
            if (!$assignment->activo) {
                throw new \Exception('Esta asignación ya está cancelada.');
            }

            // Cambiar el estado de la asignación a inactiva
            $assignment->activo = false;
            $assignment->save();

            // CORRECCIÓN: También actualizar el estado del lead a "Disponible" o el estado inicial
            $estadoDisponible = EstadoLead::where('nombre_estado', 'Nuevo')->first(); // o el estado inicial que uses
            if ($estadoDisponible) {
                $assignment->lead->update([
                    'estado_actual_id' => $estadoDisponible->id
                ]);
            }

            DB::commit();

            return redirect()->route('leads.assign.history')
                ->with('success', 'Asignación cancelada correctamente. El lead ahora está disponible para nueva asignación.');
        } catch (Throwable $e) {
            DB::rollBack();
            Log::error("Error al cancelar asignación de lead", [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'assignment_id' => $assignment->id,
                'user_id' => Auth::id()
            ]);
            return redirect()->route('leads.assign.history')
                ->with('error', 'Error al cancelar la asignación: ' . $e->getMessage());
        }
    }

    /**
     * Verificar si el usuario tiene rol de marketing
     * Método alternativo para evitar advertencias del IDE
     */
    private function userHasMarketingRole(User $user): bool
    {
        // Método 1: Usando hasRole (puede generar advertencia pero funciona)
        // return $user->hasRole('marketing');

        // Método 2: Verificación manual
        return $user->roles()->where('name', 'marketing')->exists();

        // Método 3: Usando getRoleNames
        // return $user->getRoleNames()->contains('marketing');
    }
}
