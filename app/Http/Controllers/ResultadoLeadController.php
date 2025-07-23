<?php

namespace App\Http\Controllers;

use App\Models\ResultadoLead;
use App\Http\Requests\StoreResultadoLeadRequest;
use App\Http\Requests\UpdateResultadoLeadRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class ResultadoLeadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $resultados = ResultadoLead::latest()->get();
        return view('leads.configuracion.resultados.index', compact('resultados'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('leads.configuracion.resultados.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreResultadoLeadRequest $request)
    {
        try {
            DB::beginTransaction();

            $resultado = ResultadoLead::create($request->validated());

            DB::commit();

            return redirect()->route('leads.results')
                ->with('success', 'Resultado creado exitosamente');
        } catch (Throwable $e) {
            DB::rollBack();
            Log::error("Error al crear resultado", ['error' => $e]);
            return redirect()->route('leads.results.create')
                ->with('error', 'Error al crear el resultado');
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
    public function edit(ResultadoLead $resultado)
    {
        return view('leads.configuracion.resultados.edit', compact('resultado'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateResultadoLeadRequest $request, ResultadoLead $resultado)
    {
        try {
            DB::beginTransaction();

            $resultado->update($request->validated());

            DB::commit();

            return redirect()->route('leads.results')
                ->with('success', 'Resultado actualizado exitosamente');
        } catch (Throwable $e) {
            DB::rollBack();
            Log::error("Error al actualizar resultado", ['error' => $e]);
            return redirect()->route('leads.results.edit', $resultado)
                ->with('error', 'Error al actualizar el resultado');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ResultadoLead $resultado)
    {
        try {
            DB::beginTransaction();

            $resultado->delete();

            DB::commit();

            return redirect()->route('leads.results')
                ->with('success', 'Resultado eliminado exitosamente');
        } catch (Throwable $e) {
            DB::rollBack();
            Log::error("Error al eliminar el resultado", ['error' => $e->getMessage()]);
            return redirect()->route('leads.results')
                ->with('error', 'Error al eliminar el resultado: ' . $e->getMessage());
        }
    }
}
