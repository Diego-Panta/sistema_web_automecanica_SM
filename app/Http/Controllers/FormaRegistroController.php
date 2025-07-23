<?php

namespace App\Http\Controllers;

use App\Models\FormaRegistro;
use App\Http\Requests\StoreFormaRegistroRequest;
use App\Http\Requests\UpdateFormaRegistroRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class FormaRegistroController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $formas = FormaRegistro::latest()->get();
        return view('leads.configuracion.formas_registros.index', compact('formas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('leads.configuracion.formas_registros.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFormaRegistroRequest $request)
    {
        try {
            DB::beginTransaction();

            $forma = FormaRegistro::create($request->validated());

            DB::commit();

            return redirect()->route('leads.registrations')
                ->with('success', 'Forma de registro creada exitosamente');
        } catch (Throwable $e) {
            DB::rollBack();
            Log::error("Error al crear forma de registro", ['error' => $e]);
            return redirect()->route('leads.registrations.create')
                ->with('error', 'Error al crear la forma de registro');
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
    public function edit(FormaRegistro $registro)
    {
        return view('leads.configuracion.formas_registros.edit', ['forma' => $registro]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFormaRegistroRequest $request, FormaRegistro $registro)
    {
        try {
            DB::beginTransaction();

            $registro->update($request->validated());

            DB::commit();

            return redirect()->route('leads.registrations')
                ->with('success', 'Forma de registro actualizada exitosamente');
        } catch (Throwable $e) {
            DB::rollBack();
            Log::error("Error al actualizar forma de registro", ['error' => $e]);
            return redirect()->route('leads.registrations.edit', $registro)
                ->with('error', 'Error al actualizar la forma de registro');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FormaRegistro $registro)
    {
        try {
            DB::beginTransaction();

            $registro->delete();

            DB::commit();

            return redirect()->route('leads.registrations')
                ->with('success', 'Forma de registro eliminada exitosamente');
        } catch (Throwable $e) {
            DB::rollBack();
            Log::error("Error al eliminar la forma de registro", ['error' => $e->getMessage()]);
            return redirect()->route('leads.registrations')
                ->with('error', 'Error al eliminar la forma de registro: ' . $e->getMessage());
        }
    }
}
