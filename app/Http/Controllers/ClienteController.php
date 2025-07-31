<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\EstadoCliente;
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
        $clientes = Cliente::with('estado')
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
            'estados' => EstadoCliente::all()
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
        $cliente->load(['estado', 'leads']);
        return view('configuracionGeneral.clientes.listado.show', compact('cliente'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cliente $cliente)
    {
        return view('configuracionGeneral.clientes.listado.edit', [
            'cliente' => $cliente,
            'estados' => EstadoCliente::all()
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

            $cliente->delete();

            DB::commit();

            return redirect()->route('clientes.index')
                ->with('success', 'Cliente eliminado exitosamente');
        } catch (Throwable $e) {
            DB::rollBack();
            Log::error("Error al eliminar cliente", ['error' => $e]);
            return redirect()->route('clientes.index')
                ->with('error', 'Error al eliminar el cliente');
        }
    }
}
