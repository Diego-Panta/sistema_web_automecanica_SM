<?php

namespace App\Http\Controllers;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Exceptions\PermissionDoesNotExist;
use Spatie\Permission\Exceptions\GuardDoesNotMatch;
use Throwable;

class RolePermissionController extends Controller
{
    /**
     * Muestra la lista de roles con sus permisos.
     */
    public function index()
    {
        $roles = Role::with('permissions')->orderBy('name')->get();
        return view('users.roles_permisos.role_permissions.index', compact('roles'));
    }

    /**
     * Muestra el formulario para editar los permisos de un rol.
     */
    public function edit(Role $role)
    {
        $role->load('permissions');
        $permissions = Permission::where('guard_name', $role->guard_name)
            ->orderBy('name')
            ->get();

        return view('users.roles_permisos.role_permissions.edit', compact('role', 'permissions'));
    }

    /**
     * Actualiza los permisos asignados al rol.
     */
    public function update(Request $request, Role $role)
    {
        $request->validate([
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        try {
            DB::beginTransaction();

            $this->syncPermissionsWithValidation($role, $request->permissions ?? []);

            DB::commit();

            return redirect()->route('users.roles')
                ->with('success', 'Permisos asignados al rol exitosamente');
        } catch (Throwable $e) {
            DB::rollBack();

            Log::error("Error al asignar permisos al rol", [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'input' => $request->all(),
                'role_id' => $role->id
            ]);

            return redirect()->route('users.role-permissions.edit', $role)
                ->with('error', 'Error al asignar permisos al rol: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Valida y sincroniza los permisos con el rol, asegurando que el guard coincida.
     */
    protected function syncPermissionsWithValidation(Role $role, array $permissionIds)
    {
        $permissions = Permission::whereIn('id', $permissionIds)->get();

        if ($permissions->count() !== count($permissionIds)) {
            $missing = array_diff($permissionIds, $permissions->pluck('id')->toArray());
            throw new PermissionDoesNotExist("Algunos permisos no existen: " . implode(', ', $missing));
        }

        foreach ($permissions as $permission) {
            if ($permission->guard_name !== $role->guard_name) {
                throw new GuardDoesNotMatch("El guard del permiso {$permission->name} ({$permission->guard_name}) no coincide con el del rol ({$role->guard_name})");
            }
        }

        $role->syncPermissions($permissions);

        Log::info("Permisos sincronizados desde RolePermissionController", [
            'role_id' => $role->id,
            'permissions' => $permissions->pluck('name')->toArray()
        ]);
    }

    /**
     * Métodos no implementados explícitamente.
     */
    public function create()
    {
        abort(404);
    }

    public function store(Request $request)
    {
        abort(404);
    }

    public function show(string $id)
    {
        abort(404);
    }

    public function destroy(string $id)
    {
        abort(404);
    }
}
