<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\Cliente;
use App\Models\Canale;
use App\Models\TipoLead;
use App\Models\EstadoLead;
use App\Models\ResultadoLead;
use App\Models\MedioContacto;
use App\Models\FormaRegistro;
use App\Models\EstadoCliente;
use App\Models\MarcaVehiculo;
use App\Models\TipoDocumento;
use App\Models\TipoServicio;
use App\Http\Requests\StoreLeadRequest;
use App\Http\Requests\UpdateLeadRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;


class LeadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $leads = Lead::with([
            'cliente',
            'tipo',
            'estadoActual',
            'canal',
            'medioContacto'
        ])
            ->latest()
            ->paginate(20);

        return view('leads.listado.index', compact('leads'));
    }

    /**
     * Show the form for creating a new resource.
     */

    public function create()
    {
        return $this->createManual(); // Redirige al formulario manual por defecto
    }

    public function createManual()
    {
        return view('leads.nuevo.manual.create', [
            'estadosCliente' => EstadoCliente::all(),
            'canales' => Canale::all(),
            'tipos' => TipoLead::all(),
            'estadosLead' => EstadoLead::all(),
            'mediosContacto' => MedioContacto::all(),
            'formasRegistro' => FormaRegistro::all(),
            'marcas' => MarcaVehiculo::all(),
            'clientes' => Cliente::all(),
            'tiposDocumento' => TipoDocumento::all(),
            'tiposServicio' => TipoServicio::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLeadRequest $request)
    {
        return $this->storeManual($request); // Por defecto usa el store manual
    }

    public function storeManual(StoreLeadRequest $request)
    {
        try {
            DB::beginTransaction();

            // Si se seleccionó un cliente existente
            if ($request->tipo_cliente === 'existente') {
                $cliente = Cliente::findOrFail($request->cliente_id);
            }
            // Si se está creando un nuevo cliente
            else {
                $cliente = Cliente::create([
                    'estado_cliente_id' => $request->estado_cliente_id,
                    'nombre' => $request->nombre,
                    'apellido_paterno' => $request->apellido_paterno,
                    'apellido_materno' => $request->apellido_materno,
                    'tipo_documento_id' => $request->tipo_documento_id,
                    'numero_documento' => $request->numero_documento,
                    'celular' => $request->celular,
                    'celular_alterno' => $request->celular_alterno,
                    'correo' => $request->correo,
                ]);
            }

            // Determinar qué campo de placa usar
            $tipoLead = $this->getTipoLeadFromRequest($request);

            $numeroPlaca = null;
            $consulta = null;

            if ($tipoLead === 'postventa') {
                $numeroPlaca = $request->numero_placa_postventa;
                $consulta = $request->consulta_postventa;
            } elseif ($tipoLead === 'repuesto') {
                $numeroPlaca = $request->numero_placa_repuesto;
                $consulta = $request->consulta_repuesto;
            }

            // Crear el lead asociado al cliente
            $lead = Lead::create([
                'cliente_id' => $cliente->id,
                'canal_id' => $request->canal_id,
                'tipo_id' => $request->tipo_id,
                'estado_actual_id' => $request->estado_actual_id,
                'medio_contacto_id' => $request->medio_contacto_id,
                'forma_registro_id' => $request->forma_registro_id,
                'marca_id' => $request->marca_id,
                'tipo_servicio_id' => $request->tipo_servicio_id,
                'financiamiento' => $request->has('financiamiento') ? (bool) $request->financiamiento : false,
                'tiempo_compra' => $request->tiempo_compra,
                'numero_placa' => $numeroPlaca,
                'kilometraje' => $request->kilometraje,
                'fecha_cita' => $request->fecha_cita,
                'horario_cita' => $request->horario_cita,
                'observacion' => $request->observacion,
                'consulta' => $consulta, // Nuevo campo
                'usuario_creador_id' => auth()->id(),
            ]);

            DB::commit();

            return redirect()->route('leads.show', $lead)
                ->with('success', 'Lead creado exitosamente');
        } catch (Throwable $e) {
            DB::rollBack();
            Log::error("Error al crear lead", ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error al crear el lead: ' . $e->getMessage());
        }
    }

    private function getTipoLeadFromRequest($request): ?string
    {
        if (!$request->has('tipo_id')) {
            return null;
        }

        try {
            $tipo = \App\Models\TipoLead::find($request->tipo_id);
            if (!$tipo) return null;

            $nombreTipo = strtolower($tipo->nombre_tipo);

            if (str_contains($nombreTipo, 'compra') || str_contains($nombreTipo, 'cotización')) {
                return 'compra';
            } elseif (str_contains($nombreTipo, 'postventa') || str_contains($nombreTipo, 'servicio')) {
                return 'postventa';
            } elseif (str_contains($nombreTipo, 'repuesto') || str_contains($nombreTipo, 'cotiza tu repuesto')) {
                return 'repuesto';
            }
        } catch (\Exception $e) {
            return null;
        }

        return null;
    }

    /**
     * Display the specified resource.
     */
    public function show(Lead $lead)
    {
        $lead->load([
            'cliente',
            'tipo',
            'estadoActual',
            'resultado',
            'canal',
            'medioContacto',
            'formaRegistro',
            'marca',
            'tipoServicio',
            'creador',
            'asignaciones.usuarioAsignado',
            'historialEstados.estado',
            'accionesRealizadas.accion',
            'accionesRealizadas.usuario'
        ]);

        return view('leads.detalle.show', compact('lead'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Lead $lead)
    {
        return view('leads.nuevo.manual.edit', [
            'lead' => $lead,
            'clientes' => Cliente::all(),
            'canales' => Canale::all(),
            'tipos' => TipoLead::all(),
            'estados' => EstadoLead::all(),
            'resultados' => ResultadoLead::all(),
            'mediosContacto' => MedioContacto::all(),
            'formasRegistro' => FormaRegistro::all(),
            'marcas' => MarcaVehiculo::all(),
            'tiposDocumento' => TipoDocumento::all(),
            'tiposServicio' => TipoServicio::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLeadRequest $request, Lead $lead)
    {
        try {
            Log::info("Iniciando actualización del lead", ['lead_id' => $lead->id, 'request_data' => $request->all()]);

            DB::beginTransaction();

            $tipoLead = $this->getTipoLeadFromRequest($request);

            $numeroPlaca = $lead->numero_placa;
            $consulta = $lead->consulta;

            if ($tipoLead === 'postventa') {
                $numeroPlaca = $request->numero_placa_postventa;
                $consulta = $request->consulta_postventa;
            } elseif ($tipoLead === 'repuesto') {
                $numeroPlaca = $request->numero_placa_repuesto;
                $consulta = $request->consulta_repuesto;
            }

            $lead->update([
                'cliente_id' => $request->cliente_id, // Mantener la relación con el cliente
                'canal_id' => $request->canal_id,
                'tipo_id' => $request->tipo_id,
                'estado_actual_id' => $request->estado_actual_id,
                'resultado_id' => $request->resultado_id,
                'medio_contacto_id' => $request->medio_contacto_id,
                'forma_registro_id' => $request->forma_registro_id,
                'marca_id' => $request->marca_id,
                'tipo_servicio_id' => $request->tipo_servicio_id,
                'financiamiento' => $request->has('financiamiento') ? (bool) $request->financiamiento : false,
                'tiempo_compra' => $request->tiempo_compra,
                'numero_placa' => $numeroPlaca,
                'kilometraje' => $request->kilometraje,
                'fecha_cita' => $request->fecha_cita,
                'horario_cita' => $request->horario_cita,
                'observacion' => $request->observacion,
                'consulta' => $consulta,
                'fecha_cierre' => $request->fecha_cierre,
            ]);

            Log::info("Lead actualizado exitosamente", ['lead_id' => $lead->id]);

            DB::commit();

            return redirect()->route('leads.show', $lead)
                ->with('success', 'Lead actualizado exitosamente');
        } catch (Throwable $e) {
            DB::rollBack();
            Log::error("Error al actualizar lead", ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString(), 'lead_id' => $lead->id]);
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error al actualizar el lead: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lead $lead)
    {
        try {
            DB::beginTransaction();

            $lead->delete();

            DB::commit();

            return redirect()->route('leads.index')
                ->with('success', 'Lead eliminado exitosamente');
        } catch (Throwable $e) {
            DB::rollBack();
            Log::error("Error al eliminar lead", ['error' => $e->getMessage()]);
            return redirect()->route('leads.index')
                ->with('error', 'Error al eliminar el lead');
        }
    }
}
