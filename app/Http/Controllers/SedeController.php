<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sede;
use App\Http\Requests\StoreSedeRequest;
use App\Http\Requests\UpdateSedeRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class SedeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sedes = Sede::latest()->get();
        return view('configuracionGeneral.sedes.index', compact('sedes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('configuracionGeneral.sedes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSedeRequest $request)
    {
        try {
            DB::beginTransaction();

            $sede = Sede::create($request->validated());

            DB::commit();

            return redirect()->route('locations.sedes')
                ->with('success', 'Sede creada exitosamente');
        } catch (Throwable $e) {
            DB::rollBack();
            Log::error("Error al crear sede", ['error' => $e]);
            return redirect()->route('locations.sedes.create')
                ->with('error', 'Error al crear la sede');
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
    public function edit(Sede $sede)
    {
        return view('configuracionGeneral.sedes.edit', ['sede' => $sede]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSedeRequest $request, Sede $sede)
    {
        try {
            DB::beginTransaction();

            $sede->update($request->validated());

            DB::commit();

            return redirect()->route('locations.sedes')
                ->with('success', 'Sede actualizada exitosamente');
        } catch (Throwable $e) {
            DB::rollBack();
            Log::error("Error al actualizar sede", ['error' => $e]);
            return redirect()->route('locations.sedes.edit', $sede)
                ->with('error', 'Error al actualizar la sede');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($sede_id)
    {
        try {
            DB::beginTransaction();

            $sede = Sede::findOrFail($sede_id);
            $sede->delete();

            DB::commit();

            return redirect()->route('locations.sedes')
                ->with('success', 'Sede eliminada exitosamente');
        } catch (Throwable $e) {
            DB::rollBack();
            Log::error("Error al eliminar la sede", ['error' => $e->getMessage()]);
            return redirect()->route('locations.sedes')
                ->with('error', 'Error al eliminar la sede: ' . $e->getMessage());
        }
    }
    
}
