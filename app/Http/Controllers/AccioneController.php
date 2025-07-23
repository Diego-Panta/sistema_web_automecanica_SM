<?php

namespace App\Http\Controllers;

use App\Models\Accione;
use App\Http\Requests\StoreAccioneRequest;
use App\Http\Requests\UpdateAccioneRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class AccioneController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $acciones = Accione::latest()->get();
        return view('configuracionGeneral.acciones.index', compact('acciones'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('configuracionGeneral.acciones.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAccioneRequest $request)
    {
        try {
            DB::beginTransaction();

            $accion = Accione::create($request->validated());

            DB::commit();

            return redirect()->route('accions.index')
                ->with('success', 'Acción creada exitosamente');
        } catch (Throwable $e) {
            DB::rollBack();
            Log::error("Error al crear acción", ['error' => $e]);
            return redirect()->route('accions.create')
                ->with('error', 'Error al crear la acción');
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
    public function edit(Accione $accion)
    {
        return view('configuracionGeneral.acciones.edit', compact('accion'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAccioneRequest $request, Accione $accion)
    {
        try {
            DB::beginTransaction();

            $accion->update($request->validated());

            DB::commit();

            return redirect()->route('accions.index')
                ->with('success', 'Acción actualizada exitosamente');
        } catch (Throwable $e) {
            DB::rollBack();
            Log::error("Error al actualizar acción", ['error' => $e]);
            return redirect()->route('accions.edit', $accion)
                ->with('error', 'Error al actualizar la acción');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Accione $accion)
    {
        try {
            DB::beginTransaction();

            // Verificar si hay acciones realizadas asociadas
            if ($accion->realizaciones()->exists()) {
                throw new \Exception('No se puede eliminar la acción porque tiene registros asociados.');
            }

            $accion->delete();

            DB::commit();

            return redirect()->route('accions.index')
                ->with('success', 'Acción eliminada exitosamente');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Error al eliminar la acción", ['error' => $e->getMessage()]);
            return redirect()->route('accions.index')
                ->with('error', 'Error al eliminar la acción: ' . $e->getMessage());
        }
    }
}
