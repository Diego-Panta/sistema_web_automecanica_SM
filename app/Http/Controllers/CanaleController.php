<?php

namespace App\Http\Controllers;

use App\Models\Canale;
use App\Http\Requests\StoreCanaleRequest;
use App\Http\Requests\UpdateCanaleRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class CanaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $canales = Canale::latest()->get();
        return view('leads.configuracion.canales.index', compact('canales'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('leads.configuracion.canales.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCanaleRequest $request)
    {
        try {
            DB::beginTransaction();

            $canal = Canale::create($request->validated());

            DB::commit();

            return redirect()->route('leads.channels')
                ->with('success', 'Canal creado exitosamente');
        } catch (Throwable $e) {
            DB::rollBack();
            Log::error("Error al crear canal", ['error' => $e]);
            return redirect()->route('leads.channels')
                ->with('error', 'Error al crear el canal');
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
    public function edit(Canale $canal)
    {
        return view('leads.configuracion.canales.edit', compact('canal'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCanaleRequest $request, Canale $canal)
    {
        try {
            DB::beginTransaction();

            $canal->update($request->validated());

            DB::commit();

            return redirect()->route('leads.channels')
                ->with('success', 'Canal actualizado exitosamente');
        } catch (Throwable $e) {
            DB::rollBack();
            Log::error("Error al actualizar canal", ['error' => $e]);
            return redirect()->route('leads.channels')
                ->with('error', 'Error al actualizar el canal');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($canal_id)
    {
        try {
            DB::beginTransaction();

            $canal = Canale::findOrFail($canal_id);
            $canal->delete();

            DB::commit();

            return redirect()->route('leads.channels')
                ->with('success', 'Canal eliminado exitosamente');
        } catch (Throwable $e) {
            DB::rollBack();
            Log::error("Error al eliminar el canal", ['error' => $e->getMessage()]);
            return redirect()->route('leads.channels')
                ->with('error', 'Error al eliminar el canal: ' . $e->getMessage());
        }
    
    }
}
