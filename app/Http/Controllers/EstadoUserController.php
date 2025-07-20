<?php

namespace App\Http\Controllers;

use App\Models\EstadoUser;
use App\Http\Requests\StoreEstadoUserRequest;
use App\Http\Requests\UpdateEstadoUserRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class EstadoUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $estados = EstadoUser::latest()->get();
        return view('users.configuracion.estados.index', compact('estados'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('users.configuracion.estados.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEstadoUserRequest $request)
    {
        try {
            DB::beginTransaction();

            $estadoUser = EstadoUser::create($request->validated());

            DB::commit();

            return redirect()->route('users.status')
                ->with('success', 'Estado de usuario creado exitosamente');
        } catch (Throwable $e) {
            DB::rollBack();
            Log::error("Error al crear estado de usuario", ['error' => $e]);
            return redirect()->route('users.status')
                ->with('error', 'Error al crear el estado de usuario');
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
    public function edit(EstadoUser $estado)
    {
        return view('users.configuracion.estados.edit', compact('estado'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEstadoUserRequest $request, EstadoUser $estado)
    {
        try {
            DB::beginTransaction();

            $estado->update($request->validated());

            DB::commit();

            return redirect()->route('users.status')
                ->with('success', 'Estado de usuario actualizado exitosamente');
        } catch (Throwable $e) {
            DB::rollBack();
            Log::error("Error al actualizar estado de usuario", ['error' => $e]);
            return redirect()->route('users.status')
                ->with('error', 'Error al actualizar el estado de usuario');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($estado_id)
    {
        try {
            DB::beginTransaction();

            $estadoUser = EstadoUser::findOrFail($estado_id);
            $estadoUser->delete();

            DB::commit();

            return redirect()->route('users.status')
                ->with('success', 'Estado de usuario eliminado exitosamente');
        } catch (Throwable $e) {
            DB::rollBack();
            Log::error("Error al eliminar el estado de usuario", ['error' => $e->getMessage()]);
            return redirect()->route('users.status')
                ->with('error', 'Error al eliminar el estado de usuario: ' . $e->getMessage());
        }
    }
}
