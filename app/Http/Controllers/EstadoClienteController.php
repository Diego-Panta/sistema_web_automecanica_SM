<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;
use App\Models\EstadoCliente;
use App\Http\Requests\StoreEstadoClienteRequest;
use App\Http\Requests\UpdateEstadoClienteRequest;

class EstadoClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $estados = EstadoCliente::latest()->get();
        return view('configuracionGeneral.clientes.configuracion.estados.index', compact('estados'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('configuracionGeneral.clientes.configuracion.estados.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEstadoClienteRequest $request)
    {
        try {
            DB::beginTransaction();

            $estadocliente = EstadoCliente::create($request->validated());

            DB::commit();

            return redirect()->route('clientes.status')
                ->with('success', 'Estado de cliente creado exitosamente');
        } catch (Throwable $e) {
            DB::rollBack();
            Log::error("Error al crear estado de cliente", ['error' => $e]);
            return redirect()->route('clientes.status')
                ->with('error', 'Error al crear el estado de cliente');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EstadoCliente $estado)
    {
        return view('configuracionGeneral.clientes.configuracion.estados.edit', compact('estado'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEstadoClienteRequest $request, EstadoCliente $estado)
    {
        try {
            DB::beginTransaction();

            $estado->update($request->validated());

            DB::commit();

            return redirect()->route('clientes.status')
                ->with('success', 'Estado de cliente actualizado exitosamente');
        } catch (Throwable $e) {
            DB::rollBack();
            Log::error("Error al actualizar estado de cliente", ['error' => $e]);
            return redirect()->route('clientes.status')
                ->with('error', 'Error al actualizar el estado de cliente');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EstadoCliente $estado)
    {
        try {
            DB::beginTransaction();

            $estado->delete();

            DB::commit();

            return redirect()->route('clientes.status')
                ->with('success', 'Estado de cliente eliminado exitosamente');
        } catch (Throwable $e) {
            DB::rollBack();
            Log::error("Error al eliminar el estado de cliente", ['error' => $e->getMessage()]);
            return redirect()->route('clientes.status')
                ->with('error', 'Error al eliminar el estado de cliente: ' . $e->getMessage());
        }
    }
}
