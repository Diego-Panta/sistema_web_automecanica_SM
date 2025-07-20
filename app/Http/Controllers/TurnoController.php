<?php

namespace App\Http\Controllers;

use App\Models\Turno;
use App\Http\Requests\StoreTurnoRequest;
use App\Http\Requests\UpdateTurnoRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class TurnoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $turnos = Turno::orderBy('hora_inicio')->latest()->get();
        return view('configuracionGeneral.turnos.index', compact('turnos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('configuracionGeneral.turnos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTurnoRequest $request)
    {
        try {
            DB::beginTransaction();

            $turno = Turno::create($request->validated());

            DB::commit();

            return redirect()->route('locations.turnos')
                ->with('success', 'Turno creado exitosamente');
        } catch (Throwable $e) {
            DB::rollBack();
            Log::error("Error al crear turno", ['error' => $e]);
            return redirect()->route('locations.turnos.create')
                ->with('error', 'Error al crear el turno');
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
    public function edit(Turno $turno)
    {
        return view('configuracionGeneral.turnos.edit', ['turno' => $turno]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTurnoRequest $request, Turno $turno)
    {
        try {
            DB::beginTransaction();

            $turno->update($request->validated());

            DB::commit();

            return redirect()->route('locations.turnos')
                ->with('success', 'Turno actualizado exitosamente');
        } catch (Throwable $e) {
            DB::rollBack();
            Log::error("Error al actualizar turno", ['error' => $e]);
            return redirect()->route('locations.turnos.edit', $turno)
                ->with('error', 'Error al actualizar el turno');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($turno_id)
    {
        try {
            DB::beginTransaction();

            $turno = Turno::findOrFail($turno_id);
            $turno->delete();

            DB::commit();

            return redirect()->route('locations.turnos')
                ->with('success', 'Turno eliminado exitosamente');
        } catch (Throwable $e) {
            DB::rollBack();
            Log::error("Error al eliminar el turno", ['error' => $e->getMessage()]);
            return redirect()->route('locations.turnos')
                ->with('error', 'Error al eliminar el turno: ' . $e->getMessage());
        }
    }
}
