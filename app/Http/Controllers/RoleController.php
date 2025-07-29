<?php

namespace App\Http\Controllers;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;
use Spatie\Permission\Exceptions\PermissionDoesNotExist;
use Spatie\Permission\Exceptions\GuardDoesNotMatch;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::with('permissions')->latest()->get();
        return view('users.roles_permisos.roles.index', compact('roles'));
    }

    public function create()
    {
        $permissions = Permission::orderBy('name')->get();
        return view('users.roles_permisos.roles.create', compact('permissions'));
    }

    public function store(StoreRoleRequest $request)
    {
        try {
            DB::beginTransaction();

            // Crear el rol
            $role = Role::create($request->only(['name', 'guard_name']));
            
            Log::info("Rol creado", ['role' => $role]);

            // Asignar permisos si existen
            if ($request->has('permissions')) {
                $this->syncPermissionsWithValidation($role, $request->permissions);
            }

            DB::commit();

            return redirect()->route('users.roles')
                ->with('success', 'Rol creado exitosamente');
        } catch (Throwable $e) {
            DB::rollBack();
            Log::error("Error al crear rol", [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'input' => $request->all()
            ]);
            return redirect()->route('users.roles.create')
                ->with('error', 'Error al crear el rol: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function edit(Role $role)
    {
        $role->load('permissions');
        $permissions = Permission::orderBy('name')->get();
        
        return view('users.roles_permisos.roles.edit', [
            'role' => $role,
            'permissions' => $permissions
        ]);
    }

    public function update(UpdateRoleRequest $request, Role $role)
    {
        try {
            DB::beginTransaction();

            // Actualizar datos básicos del rol
            $role->update($request->only(['name', 'guard_name']));
            
            Log::info("Rol actualizado", ['role' => $role]);

            // Sincronizar permisos
            if ($request->has('permissions')) {
                $this->syncPermissionsWithValidation($role, $request->permissions);
            } else {
                $role->syncPermissions([]);
                Log::info("Todos los permisos eliminados del rol", ['role_id' => $role->id]);
            }

            DB::commit();

            return redirect()->route('users.roles')
                ->with('success', 'Rol actualizado exitosamente');
        } catch (Throwable $e) {
            DB::rollBack();
            Log::error("Error al actualizar rol", [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'input' => $request->all(),
                'role' => $role
            ]);
            return redirect()->route('users.roles.edit', $role)
                ->with('error', 'Error al actualizar el rol: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy(Role $role)
    {
        try {
            DB::beginTransaction();

            if ($role->users()->exists()) {
                throw new \Exception('No se puede eliminar el rol porque tiene usuarios asignados.');
            }

            // Eliminar permisos asociados primero
            $role->syncPermissions([]);
            $role->delete();

            DB::commit();

            return redirect()->route('users.roles')
                ->with('success', 'Rol eliminado exitosamente');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Error al eliminar el rol", [
                'error' => $e->getMessage(),
                'role' => $role
            ]);
            return redirect()->route('users.roles')
                ->with('error', 'Error al eliminar el rol: ' . $e->getMessage());
        }
    }

    /**
     * Sincroniza permisos con validación de guard
     */
    protected function syncPermissionsWithValidation(Role $role, array $permissionIds)
    {
        $permissions = Permission::whereIn('id', $permissionIds)->get();
        
        // Verificar que todos los permisos existan
        if ($permissions->count() !== count($permissionIds)) {
            $missingIds = array_diff($permissionIds, $permissions->pluck('id')->toArray());
            throw new PermissionDoesNotExist("Algunos permisos no existen: " . implode(', ', $missingIds));
        }

        // Verificar que los guards coincidan
        foreach ($permissions as $permission) {
            if ($permission->guard_name !== $role->guard_name) {
                throw new GuardDoesNotMatch(
                    "El guard del permiso {$permission->name} ({$permission->guard_name}) " .
                    "no coincide con el guard del rol ({$role->guard_name})"
                );
            }
        }

        // Sincronizar permisos
        $role->syncPermissions($permissions);
        
        Log::info("Permisos sincronizados para el rol", [
            'role_id' => $role->id,
            'permissions' => $permissions->pluck('name')->toArray()
        ]);
    }
}