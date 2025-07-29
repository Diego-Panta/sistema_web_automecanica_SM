<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Turno;
use App\Models\Sede;
use App\Models\EstadoUser;
use Spatie\Permission\Models\Role;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Throwable;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::with(['laborale.sede', 'laborale.turno', 'laborale.estado', 'roles'])
                    ->latest()
                    ->get();
        
        return view('users.listado.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $turnos = Turno::orderBy('nombre_turno')->get();
        $sedes = Sede::orderBy('nombre_sede')->get();
        $estados = EstadoUser::orderBy('nombre_estado')->get();
        $roles = Role::orderBy('name')->get();
        
        return view('users.nuevo.create', compact('turnos', 'sedes', 'estados', 'roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        try {
            DB::beginTransaction();

            // Crear usuario
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'dni' => $request->dni,
                'celular' => $request->celular,
                'celular_alterno' => $request->celular_alterno,
                'email_personal' => $request->email_personal,
                'fecha_nacimiento' => $request->fecha_nacimiento,
                'direccion' => $request->direccion,
            ]);

            // Crear datos laborales
            $user->laborale()->create([
                'turno_id' => $request->turno_id,
                'sede_id' => $request->sede_id,
                'estado_user_id' => $request->estado_user_id,
                'codigo_trabajador' => $request->codigo_trabajador,
                'fecha_contratacion_inicio' => $request->fecha_contratacion_inicio,
                'fecha_contratacion_fin' => $request->fecha_contratacion_fin,
            ]);

            // Asignar roles
            if ($request->has('roles')) {
                $user->roles()->sync($request->roles);
            }

            DB::commit();

            return redirect()->route('users.index')
                ->with('success', 'Usuario creado exitosamente');
        } catch (Throwable $e) {
            DB::rollBack();
            Log::error("Error al crear usuario", ['error' => $e]);
            return redirect()->route('users.create')
                ->with('error', 'Error al crear el usuario: ' . $e->getMessage())
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
    public function edit(User $user)
    {
        $user->load('laborale', 'roles');
        
        $turnos = Turno::orderBy('nombre_turno')->get();
        $sedes = Sede::orderBy('nombre_sede')->get();
        $estados = EstadoUser::orderBy('nombre_estado')->get();
        $roles = Role::orderBy('name')->get();
        
        return view('users.nuevo.edit', [
            'user' => $user,
            'turnos' => $turnos,
            'sedes' => $sedes,
            'estados' => $estados,
            'roles' => $roles
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        try {
            DB::beginTransaction();

            // Actualizar datos personales
            $userData = [
                'name' => $request->name,
                'email' => $request->email,
                'dni' => $request->dni,
                'celular' => $request->celular,
                'celular_alterno' => $request->celular_alterno,
                'email_personal' => $request->email_personal,
                'fecha_nacimiento' => $request->fecha_nacimiento,
                'direccion' => $request->direccion,
            ];

            // Actualizar contraseña solo si se proporcionó
            if ($request->filled('password')) {
                $userData['password'] = Hash::make($request->password);
            }

            $user->update($userData);

            // Actualizar datos laborales
            $user->laborale()->updateOrCreate(
                ['user_id' => $user->id],
                [
                    'turno_id' => $request->turno_id,
                    'sede_id' => $request->sede_id,
                    'estado_user_id' => $request->estado_user_id,
                    'codigo_trabajador' => $request->codigo_trabajador,
                    'fecha_contratacion_inicio' => $request->fecha_contratacion_inicio,
                    'fecha_contratacion_fin' => $request->fecha_contratacion_fin,
                ]
            );

            // Sincronizar roles
            $user->roles()->sync($request->roles ?? []);

            DB::commit();

            return redirect()->route('users.index')
                ->with('success', 'Usuario actualizado exitosamente');
        } catch (Throwable $e) {
            DB::rollBack();
            Log::error("Error al actualizar usuario", ['error' => $e]);
            return redirect()->route('users.edit', $user)
                ->with('error', 'Error al actualizar el usuario: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        try {
            DB::beginTransaction();

            // Verificar si hay leads asociados
            if ($user->leadCreados()->exists() || $user->asignacionesRecibidas()->exists()) {
                throw new \Exception('No se puede eliminar el usuario porque tiene leads asociados.');
            }

            // Eliminar datos laborales primero
            $user->laborale()->delete();
            
            // Eliminar usuario
            $user->delete();

            DB::commit();

            return redirect()->route('users.index')
                ->with('success', 'Usuario eliminado exitosamente');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Error al eliminar el usuario", ['error' => $e->getMessage()]);
            return redirect()->route('users.index')
                ->with('error', 'Error al eliminar el usuario: ' . $e->getMessage());
        }
    }
}
