<?php

namespace App\Http\Controllers;

use App\Models\MedioContacto;
use App\Http\Requests\StoreMedioContactoRequest;
use App\Http\Requests\UpdateMedioContactoRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class MedioContactoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $medios = MedioContacto::latest()->get();
        return view('leads.configuracion.medios_contactos.index', compact('medios'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('leads.configuracion.medios_contactos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMedioContactoRequest $request)
    {
        try {
            DB::beginTransaction();

            $medio = MedioContacto::create($request->validated());

            DB::commit();

            return redirect()->route('leads.contacts')
                ->with('success', 'Medio de contacto creado exitosamente');
        } catch (Throwable $e) {
            DB::rollBack();
            Log::error("Error al crear medio de contacto", ['error' => $e]);
            return redirect()->route('leads.contacts.create')
                ->with('error', 'Error al crear el medio de contacto');
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
    public function edit(MedioContacto $contacto)
    {
        return view('leads.configuracion.medios_contactos.edit', ['medio' => $contacto]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMedioContactoRequest $request, MedioContacto $contacto)
    {
        try {
            DB::beginTransaction();

            $contacto->update($request->validated());

            DB::commit();

            return redirect()->route('leads.contacts')
                ->with('success', 'Medio de contacto actualizado exitosamente');
        } catch (Throwable $e) {
            DB::rollBack();
            Log::error("Error al actualizar medio de contacto", ['error' => $e]);
            return redirect()->route('leads.contacts.edit', $contacto)
                ->with('error', 'Error al actualizar el medio de contacto');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MedioContacto $contacto)
    {
        try {
            DB::beginTransaction();

            $contacto->delete();

            DB::commit();

            return redirect()->route('leads.contacts')
                ->with('success', 'Medio de contacto eliminado exitosamente');
        } catch (Throwable $e) {
            DB::rollBack();
            Log::error("Error al eliminar el medio de contacto", ['error' => $e->getMessage()]);
            return redirect()->route('leads.contacts')
                ->with('error', 'Error al eliminar el medio de contacto: ' . $e->getMessage());
        }
    }
}
