<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\EstadoCliente;
use App\Models\TipoDocumento;
use App\Http\Requests\StoreClienteRequest;
use App\Http\Requests\UpdateClienteRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clientes = Cliente::with(['estado', 'tipoDocumento'])
            ->latest()
            ->paginate(20);

        return view('configuracionGeneral.clientes.listado.index', compact('clientes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('configuracionGeneral.clientes.listado.create', [
            'estados' => EstadoCliente::all(),
            'tiposDocumento' => TipoDocumento::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreClienteRequest $request)
    {
        try {
            DB::beginTransaction();

            $cliente = Cliente::create($request->validated());

            DB::commit();

            return redirect()->route('clientes.index')
                ->with('success', 'Cliente creado exitosamente');
        } catch (Throwable $e) {
            DB::rollBack();
            Log::error("Error al crear cliente", ['error' => $e]);
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error al crear el cliente');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Cliente $cliente)
    {
        $cliente->load(['estado', 'tipoDocumento', 'leads']);
        return view('configuracionGeneral.clientes.listado.show', compact('cliente'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cliente $cliente)
    {
        return view('configuracionGeneral.clientes.listado.edit', [
            'cliente' => $cliente,
            'estados' => EstadoCliente::all(),
            'tiposDocumento' => TipoDocumento::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateClienteRequest $request, Cliente $cliente)
    {
        try {
            DB::beginTransaction();

            $cliente->update($request->validated());

            DB::commit();

            return redirect()->route('clientes.index')
                ->with('success', 'Cliente actualizado exitosamente');
        } catch (Throwable $e) {
            DB::rollBack();
            Log::error("Error al actualizar cliente", ['error' => $e]);
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error al actualizar el cliente');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cliente $cliente)
    {
        try {
            DB::beginTransaction();

            // Obtener los estados activo e inactivo
            $estadoActivo = EstadoCliente::where('nombre_estado', 'Activo')->first();
            $estadoInactivo = EstadoCliente::where('nombre_estado', 'Inactivo')->first();

            if (!$estadoActivo || !$estadoInactivo) {
                throw new \Exception('No se encontraron los estados Activo/Inactivo en el sistema.');
            }

            // Determinar el nuevo estado
            $estadoActual = $cliente->estado_cliente_id;
            $nuevoEstado = ($estadoActual == $estadoActivo->id) ? $estadoInactivo->id : $estadoActivo->id;

            // Actualizar el estado del cliente
            $cliente->update(['estado_cliente_id' => $nuevoEstado]);

            // Determinar el mensaje según el nuevo estado
            $message = ($nuevoEstado == $estadoActivo->id) ? 'Cliente reestablecido exitosamente' : 'Cliente desactivado exitosamente';
            $action = ($nuevoEstado == $estadoActivo->id) ? 'reestablecido' : 'desactivado';

            DB::commit();

            /*Log::info("Cliente {$action}", [
            'cliente_id' => $cliente->id,
            'cliente_name' => $cliente->nombre_completo,
            'nuevo_estado' => $nuevoEstado,
            'action_by' => auth()->id()
        ]);*/

            return redirect()->route('clientes.index')
                ->with('success', $message);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Error al cambiar estado del cliente", [
                'cliente_id' => $cliente->id,
                'error' => $e->getMessage()
            ]);
            return redirect()->route('clientes.index')
                ->with('error', 'Error al cambiar el estado del cliente: ' . $e->getMessage());
        }
    }
}
