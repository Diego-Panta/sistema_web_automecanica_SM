<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTipoLeadRequest;
use App\Http\Requests\UpdateTipoLeadRequest;
use Illuminate\Http\Request;
use App\Services\ActivityLogService;
use Illuminate\Contracts\View\View;
use App\Models\TipoLead;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class TipoLeadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tipos = TipoLead::latest()->get();
        return view('leads.configuracion.tipos.index', compact('tipos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('leads.configuracion.tipos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTipoLeadRequest $request)
    {
        try {
            DB::beginTransaction();

            $tipoLead = TipoLead::create($request->validated());

            DB::commit();

            return redirect()->route('leads.types.index')
                ->with('success', 'Tipo de lead creado exitosamente');
        } catch (Throwable $e) {
            DB::rollBack();
            Log::error("Error al crear tipo de lead", ['error' => $e]);
            return redirect()->route('leads.types.index')
                ->with('error', 'Error al crear el tipo de lead');
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
    public function edit(TipoLead $tipo)
    {
        return view('leads.configuracion.tipos.edit', compact('tipo'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTipoLeadRequest $request, TipoLead $tipo)
    {
        try {
            DB::beginTransaction();

            $tipo->update($request->validated());

            DB::commit();

            return redirect()->route('leads.types.index')
                ->with('success', 'Tipo de lead actualizado exitosamente');
        } catch (Throwable $e) {
            DB::rollBack();
            Log::error("Error al actualizar tipo de lead", ['error' => $e]);
            return redirect()->route('leads.types.index')
                ->with('error', 'Error al actualizar el tipo de lead');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($tipo_id)
    {
        try {
            DB::beginTransaction();

            $tipoLead = TipoLead::findOrFail($tipo_id);
            $tipoLead->delete();

            DB::commit();

            return redirect()->route('leads.types.index')
                ->with('success', 'Tipo de lead eliminado exitosamente');
        } catch (Throwable $e) {
            DB::rollBack();
            Log::error("Error al eliminar el tipo de lead", ['error' => $e->getMessage()]);
            return redirect()->route('leads.types.index')
                ->with('error', 'Error al eliminar el tipo de lead: ' . $e->getMessage());
        }
    }
}
