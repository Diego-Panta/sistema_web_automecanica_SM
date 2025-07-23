<?php

namespace App\Http\Controllers;

use App\Models\ModeloVehiculo;
use App\Models\MarcaVehiculo;
use App\Models\TipoVehiculo;
use App\Http\Requests\StoreModeloVehiculoRequest;
use App\Http\Requests\UpdateModeloVehiculoRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class ModeloVehiculoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $modelos = ModeloVehiculo::with(['marca', 'tipo'])->latest()->get();
        return view('configuracionGeneral.vehiculos.modelos.index', compact('modelos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $marcas = MarcaVehiculo::orderBy('nombre_marca')->get();
        $tipos = TipoVehiculo::orderBy('nombre_tipo_vehiculo')->get();
        return view('configuracionGeneral.vehiculos.modelos.create', compact('marcas', 'tipos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreModeloVehiculoRequest $request)
    {
        try {
            DB::beginTransaction();

            $modelo = ModeloVehiculo::create($request->validated());

            DB::commit();

            return redirect()->route('vehicles.models')
                ->with('success', 'Modelo de vehículo creado exitosamente');
        } catch (Throwable $e) {
            DB::rollBack();
            Log::error("Error al crear modelo de vehículo", ['error' => $e]);
            return redirect()->route('vehicles.models.create')
                ->with('error', 'Error al crear el modelo de vehículo');
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
    public function edit(ModeloVehiculo $model)
    {
        $marcas = MarcaVehiculo::orderBy('nombre_marca')->get();
        $tipos = TipoVehiculo::orderBy('nombre_tipo_vehiculo')->get();
        return view('configuracionGeneral.vehiculos.modelos.edit', [
            'modelo' => $model,
            'marcas' => $marcas,
            'tipos' => $tipos
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateModeloVehiculoRequest $request, ModeloVehiculo $model)
    {
        try {
            DB::beginTransaction();

            $model->update($request->validated());

            DB::commit();

            return redirect()->route('vehicles.models')
                ->with('success', 'Modelo de vehículo actualizado exitosamente');
        } catch (Throwable $e) {
            DB::rollBack();
            Log::error("Error al actualizar modelo de vehículo", ['error' => $e]);
            return redirect()->route('vehicles.models.edit', $model)
                ->with('error', 'Error al actualizar el modelo de vehículo');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ModeloVehiculo $model)
    {
        try {
            DB::beginTransaction();

            // Verificar si hay leads asociados
            if ($model->leads()->exists()) {
                throw new \Exception('No se puede eliminar el modelo porque tiene leads asociados.');
            }

            $model->delete();

            DB::commit();

            return redirect()->route('vehicles.models')
                ->with('success', 'Modelo de vehículo eliminado exitosamente');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Error al eliminar el modelo de vehículo", ['error' => $e->getMessage()]);
            return redirect()->route('vehicles.models')
                ->with('error', 'Error al eliminar el modelo de vehículo: ' . $e->getMessage());
        }
    }
}
