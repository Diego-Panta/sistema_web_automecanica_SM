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
use App\Models\ModeloVehiculo;
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
            'modelos' => ModeloVehiculo::all(),
            'clientes' => Cliente::all() // Agrega esta línea
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
                    'dni' => $request->dni,
                    'celular' => $request->celular,
                    'celular_alterno' => $request->celular_alterno,
                    'correo' => $request->correo,
                ]);
            }

            // Crear el lead asociado al cliente
            $lead = Lead::create([
                'cliente_id' => $cliente->id,
                'canal_id' => $request->canal_id,
                'tipo_id' => $request->tipo_id,
                'estado_actual_id' => $request->estado_actual_id,
                'medio_contacto_id' => $request->medio_contacto_id,
                'forma_registro_id' => $request->forma_registro_id,
                'modelo_id' => $request->modelo_id,
                'financiamiento' => $request->financiamiento ?? false,
                'tiempo_compra' => $request->tiempo_compra,
                'observacion' => $request->observacion,
                'usuario_creador_id' => auth()->id(),
            ]);

            DB::commit();

            return redirect()->route('leads.show', $lead)
                ->with('success', 'Lead creado exitosamente');
        } catch (Throwable $e) {
            DB::rollBack();
            Log::error("Error al crear lead", ['error' => $e]);
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error al crear el lead: ' . $e->getMessage());
        }
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
            'modeloVehiculo',
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
            'modelos' => ModeloVehiculo::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLeadRequest $request, Lead $lead)
    {
        try {
            DB::beginTransaction();

            $lead->update([
                'cliente_id' => $request->cliente_id,
                'canal_id' => $request->canal_id,
                'tipo_id' => $request->tipo_id,
                'estado_actual_id' => $request->estado_actual_id,
                'resultado_id' => $request->resultado_id,
                'medio_contacto_id' => $request->medio_contacto_id,
                'forma_registro_id' => $request->forma_registro_id,
                'modelo_id' => $request->modelo_id,
                'financiamiento' => $request->financiamiento ?? false,
                'tiempo_compra' => $request->tiempo_compra,
                'observacion' => $request->observacion,
                'fecha_cierre' => $request->fecha_cierre,
            ]);

            DB::commit();

            return redirect()->route('leads.show', $lead)
                ->with('success', 'Lead actualizado exitosamente');
        } catch (Throwable $e) {
            DB::rollBack();
            Log::error("Error al actualizar lead", ['error' => $e]);
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error al actualizar el lead');
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
            Log::error("Error al eliminar lead", ['error' => $e]);
            return redirect()->route('leads.index')
                ->with('error', 'Error al eliminar el lead');
        }
    }
}
