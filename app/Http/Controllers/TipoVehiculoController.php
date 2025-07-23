<?php

namespace App\Http\Controllers;

use App\Models\TipoVehiculo;
use App\Http\Requests\StoreTipoVehiculoRequest;
use App\Http\Requests\UpdateTipoVehiculoRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class TipoVehiculoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tipos = TipoVehiculo::latest()->get();
        return view('configuracionGeneral.vehiculos.tipos.index', compact('tipos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('configuracionGeneral.vehiculos.tipos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTipoVehiculoRequest $request)
    {
        try {
            DB::beginTransaction();

            $tipo = TipoVehiculo::create($request->validated());

            DB::commit();

            return redirect()->route('vehicles.types')
                ->with('success', 'Tipo de vehículo creado exitosamente');
        } catch (Throwable $e) {
            DB::rollBack();
            Log::error("Error al crear tipo de vehículo", ['error' => $e]);
            return redirect()->route('vehicles.types.create')
                ->with('error', 'Error al crear el tipo de vehículo');
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
    public function edit(TipoVehiculo $type)
    {
        return view('configuracionGeneral.vehiculos.tipos.edit', ['tipo' => $type]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTipoVehiculoRequest $request, TipoVehiculo $type)
    {
        try {
            DB::beginTransaction();

            $type->update($request->validated());

            DB::commit();

            return redirect()->route('vehicles.types')
                ->with('success', 'Tipo de vehículo actualizado exitosamente');
        } catch (Throwable $e) {
            DB::rollBack();
            Log::error("Error al actualizar tipo de vehículo", ['error' => $e]);
            return redirect()->route('vehicles.types.edit', $type)
                ->with('error', 'Error al actualizar el tipo de vehículo');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TipoVehiculo $type)
    {
        try {
            DB::beginTransaction();

            // Verificar si hay modelos asociados
            if ($type->modelos()->exists()) {
                throw new \Exception('No se puede eliminar el tipo de vehículo porque tiene modelos asociados.');
            }

            $type->delete();

            DB::commit();

            return redirect()->route('vehicles.types')
                ->with('success', 'Tipo de vehículo eliminado exitosamente');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Error al eliminar el tipo de vehículo", ['error' => $e->getMessage()]);
            return redirect()->route('vehicles.types')
                ->with('error', 'Error al eliminar el tipo de vehículo: ' . $e->getMessage());
        }
    }
}