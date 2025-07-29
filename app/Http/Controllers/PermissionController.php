<?php

namespace App\Http\Controllers;

use Spatie\Permission\Models\Permission;
use App\Http\Requests\StorePermissionRequest;
use App\Http\Requests\UpdatePermissionRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $permissions = Permission::latest()->get();
        return view('users.roles_permisos.permissions.index', compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('users.roles_permisos.permissions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePermissionRequest $request)
    {
        try {
            DB::beginTransaction();

            Permission::create($request->all());

            DB::commit();

            return redirect()->route('users.permissions')
                ->with('success', 'Permiso creado exitosamente');
        } catch (Throwable $e) {
            DB::rollBack();
            Log::error("Error al crear permiso", ['error' => $e]);
            return redirect()->route('users.permissions.create')
                ->with('error', 'Error al crear el permiso: ' . $e->getMessage())
                ->withInput();
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
    public function edit(Permission $permission)
    {
        return view('users.roles_permisos.permissions.edit', compact('permission'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePermissionRequest $request, Permission $permission)
    {
        try {
            DB::beginTransaction();

            $permission->update($request->all());

            DB::commit();

            return redirect()->route('users.permissions')
                ->with('success', 'Permiso actualizado exitosamente');
        } catch (Throwable $e) {
            DB::rollBack();
            Log::error("Error al actualizar permiso", ['error' => $e]);
            return redirect()->route('users.permissions.edit', $permission)
                ->with('error', 'Error al actualizar el permiso: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Permission $permission)
    {
        try {
            DB::beginTransaction();

            // Verificar si el permiso está asignado a algún rol
            if ($permission->roles()->exists()) {
                throw new \Exception('No se puede eliminar el permiso porque está asignado a uno o más roles.');
            }

            $permission->delete();

            DB::commit();

            return redirect()->route('users.permissions')
                ->with('success', 'Permiso eliminado exitosamente');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Error al eliminar el permiso", ['error' => $e->getMessage()]);
            return redirect()->route('users.permissions')
                ->with('error', 'Error al eliminar el permiso: ' . $e->getMessage());
        }
    }
}
