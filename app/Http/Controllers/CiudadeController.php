<?php

namespace App\Http\Controllers;

use App\Models\Ciudade;
use App\Http\Requests\StoreCiudadeRequest;
use App\Http\Requests\UpdateCiudadeRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class CiudadeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ciudades = Ciudade::latest()->get();
        return view('configuracionGeneral.ciudades.index', compact('ciudades'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('configuracionGeneral.ciudades.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCiudadeRequest $request)
    {
        try {
            DB::beginTransaction();

            $ciudad = Ciudade::create($request->validated());

            DB::commit();

            return redirect()->route('locations.ciudades')
                ->with('success', 'Ciudad creada exitosamente');
        } catch (Throwable $e) {
            DB::rollBack();
            Log::error("Error al crear ciudad", ['error' => $e]);
            return redirect()->route('locations.ciudades.create')
                ->with('error', 'Error al crear la ciudad');
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
    public function edit(Ciudade $ciudad)
    {
        return view('configuracionGeneral.ciudades.edit', compact('ciudad'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCiudadeRequest $request, Ciudade $ciudad)
    {
        try {
            DB::beginTransaction();

            $ciudad->update($request->validated());

            DB::commit();

            return redirect()->route('locations.ciudades')
                ->with('success', 'Ciudad actualizada exitosamente');
        } catch (Throwable $e) {
            DB::rollBack();
            Log::error("Error al actualizar ciudad", ['error' => $e]);
            return redirect()->route('locations.ciudades.edit', $ciudad)
                ->with('error', 'Error al actualizar la ciudad');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ciudade $ciudad)
    {
        try {
            DB::beginTransaction();

            // Verificar si hay sedes asociadas
            if ($ciudad->sedes()->exists()) {
                throw new \Exception('No se puede eliminar la ciudad porque tiene sedes asociadas.');
            }

            $ciudad->delete();

            DB::commit();

            return redirect()->route('locations.ciudades')
                ->with('success', 'Ciudad eliminada exitosamente');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Error al eliminar la ciudad", ['error' => $e->getMessage()]);
            return redirect()->route('locations.ciudades')
                ->with('error', 'Error al eliminar la ciudad: ' . $e->getMessage());
        }
    }
}
