<?php

namespace App\Http\Controllers;

use App\Models\MarcaVehiculo;
use App\Http\Requests\StoreMarcaVehiculoRequest;
use App\Http\Requests\UpdateMarcaVehiculoRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class MarcaVehiculoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $marcas = MarcaVehiculo::latest()->get();
        return view('configuracionGeneral.vehiculos.marcas.index', compact('marcas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('configuracionGeneral.vehiculos.marcas.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMarcaVehiculoRequest $request)
    {
        try {
            DB::beginTransaction();

            $marca = MarcaVehiculo::create($request->validated());

            DB::commit();

            return redirect()->route('vehicles.brands')
                ->with('success', 'Marca de vehículo creada exitosamente');
        } catch (Throwable $e) {
            DB::rollBack();
            Log::error("Error al crear marca de vehículo", ['error' => $e]);
            return redirect()->route('vehicles.brands.create')
                ->with('error', 'Error al crear la marca de vehículo');
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
    public function edit(MarcaVehiculo $brand)
    {
        return view('configuracionGeneral.vehiculos.marcas.edit', ['marca' => $brand]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMarcaVehiculoRequest $request, MarcaVehiculo $brand)
    {
        try {
            DB::beginTransaction();

            $brand->update($request->validated());

            DB::commit();

            return redirect()->route('vehicles.brands')
                ->with('success', 'Marca de vehículo actualizada exitosamente');
        } catch (Throwable $e) {
            DB::rollBack();
            Log::error("Error al actualizar marca de vehículo", ['error' => $e]);
            return redirect()->route('vehicles.brands.edit', $brand)
                ->with('error', 'Error al actualizar la marca de vehículo');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MarcaVehiculo $brand)
    {
        try {
            DB::beginTransaction();

            // Verificar si hay modelos asociados
            if ($brand->modelos()->exists()) {
                throw new \Exception('No se puede eliminar la marca porque tiene modelos asociados.');
            }

            $brand->delete();

            DB::commit();

            return redirect()->route('vehicles.brands')
                ->with('success', 'Marca de vehículo eliminada exitosamente');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Error al eliminar la marca de vehículo", ['error' => $e->getMessage()]);
            return redirect()->route('vehicles.brands')
                ->with('error', 'Error al eliminar la marca de vehículo: ' . $e->getMessage());
        }
    }
}
