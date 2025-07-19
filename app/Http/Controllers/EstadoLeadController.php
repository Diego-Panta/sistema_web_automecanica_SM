<?php

namespace App\Http\Controllers;

use App\Models\EstadoLead;
use App\Http\Requests\StoreEstadoLeadRequest;
use App\Http\Requests\UpdateEstadoLeadRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class EstadoLeadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $estados = EstadoLead::latest()->get();
        return view('leads.configuracion.estados.index', compact('estados'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('leads.configuracion.estados.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEstadoLeadRequest $request)
    {
        try {
            DB::beginTransaction();

            $estadoLead = EstadoLead::create($request->validated());

            DB::commit();

            return redirect()->route('leads.status')
                ->with('success', 'Estado de lead creado exitosamente');
        } catch (Throwable $e) {
            DB::rollBack();
            Log::error("Error al crear estado de lead", ['error' => $e]);
            return redirect()->route('leads.status')
                ->with('error', 'Error al crear el estado de lead');
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
    public function edit(EstadoLead $estado)
    {
        return view('leads.configuracion.estados.edit', compact('estado'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEstadoLeadRequest $request, EstadoLead $estado)
    {
        try {
            DB::beginTransaction();

            $estado->update($request->validated());

            DB::commit();

            return redirect()->route('leads.status')
                ->with('success', 'Estado de lead actualizado exitosamente');
        } catch (Throwable $e) {
            DB::rollBack();
            Log::error("Error al actualizar estado de lead", ['error' => $e]);
            return redirect()->route('leads.status')
                ->with('error', 'Error al actualizar el estado de lead');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($estado_id)
    {
        try {
            DB::beginTransaction();

            $estadoLead = EstadoLead::findOrFail($estado_id);
            $estadoLead->delete();

            DB::commit();

            return redirect()->route('leads.status')
                ->with('success', 'Estado de lead eliminado exitosamente');
        } catch (Throwable $e) {
            DB::rollBack();
            Log::error("Error al eliminar el estado de lead", ['error' => $e->getMessage()]);
            return redirect()->route('leads.status')
                ->with('error', 'Error al eliminar el estado de lead: ' . $e->getMessage());
        }
    }
}
