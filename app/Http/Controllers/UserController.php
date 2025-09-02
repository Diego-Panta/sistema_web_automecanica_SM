<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Turno;
use App\Models\Sede;
use App\Models\EstadoUser;
use App\Models\UserHorario;
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
        $users = User::with([
            'laborale.horarios.turno', 
            'laborale.estado', 
            'laborale.sede', // CARGAR SEDE DESDE USER_LABORALE
            'roles'
        ])->latest()->get();

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

        $diasSemana = [
            'lunes' => 'Lunes',
            'martes' => 'Martes',
            'miercoles' => 'Miércoles',
            'jueves' => 'Jueves',
            'viernes' => 'Viernes',
            'sabado' => 'Sábado',
            'domingo' => 'Domingo'
        ];

        return view('users.nuevo.create', compact('turnos', 'sedes', 'estados', 'roles', 'diasSemana'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        try {
            DB::beginTransaction();

            // Validar que solo se envíe una sede
            $request->validate([
                'sede_id' => 'required|exists:sedes,id',
            ]);

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

            // Crear datos laborales CON SEDE
            $userLaborale = $user->laborale()->create([
                'estado_user_id' => $request->estado_user_id,
                'sede_id' => $request->sede_id, // AGREGADO
                'codigo_trabajador' => $request->codigo_trabajador,
                'fecha_contratacion_inicio' => $request->fecha_contratacion_inicio,
                'fecha_contratacion_fin' => $request->fecha_contratacion_fin,
            ]);

            // Crear horarios si se proporcionaron
            if ($request->has('horarios') && is_array($request->horarios)) {
                foreach ($request->horarios as $horario) {
                    if (isset($horario['dia_semana']) && isset($horario['turno_id'])) {
                        UserHorario::create([
                            'user_laborale_id' => $userLaborale->id,
                            'dia_semana' => $horario['dia_semana'],
                            'turno_id' => $horario['turno_id'],
                        ]);
                    }
                }
            }

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
        $user->load('laborale.horarios', 'roles', 'laborale.sede'); // CARGAR SEDE

        $turnos = Turno::orderBy('nombre_turno')->get();
        $sedes = Sede::orderBy('nombre_sede')->get();
        $estados = EstadoUser::orderBy('nombre_estado')->get();
        $roles = Role::orderBy('name')->get();

        $diasSemana = [
            'lunes' => 'Lunes',
            'martes' => 'Martes',
            'miercoles' => 'Miércoles',
            'jueves' => 'Jueves',
            'viernes' => 'Viernes',
            'sabado' => 'Sábado',
            'domingo' => 'Domingo'
        ];

        return view('users.nuevo.edit', [
            'user' => $user,
            'turnos' => $turnos,
            'sedes' => $sedes,
            'estados' => $estados,
            'roles' => $roles,
            'diasSemana' => $diasSemana
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        try {
            DB::beginTransaction();

            // Validar que solo se envíe una sede
            $request->validate([
                'sede_id' => 'required|exists:sedes,id',
            ]);

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

            if ($request->filled('password')) {
                $userData['password'] = Hash::make($request->password);
            }

            $user->update($userData);

            // Actualizar datos laborales CON SEDE
            $userLaborale = $user->laborale()->updateOrCreate(
                ['user_id' => $user->id],
                [
                    'estado_user_id' => $request->estado_user_id,
                    'sede_id' => $request->sede_id, // AGREGADO
                    'codigo_trabajador' => $request->codigo_trabajador,
                    'fecha_contratacion_inicio' => $request->fecha_contratacion_inicio,
                    'fecha_contratacion_fin' => $request->fecha_contratacion_fin,
                ]
            );

            // Eliminar horarios existentes y crear nuevos
            $userLaborale->horarios()->delete();

            if ($request->has('horarios') && is_array($request->horarios)) {
                foreach ($request->horarios as $horario) {
                    if (isset($horario['dia_semana']) && isset($horario['turno_id'])) {
                        UserHorario::create([
                            'user_laborale_id' => $userLaborale->id,
                            'dia_semana' => $horario['dia_semana'],
                            'turno_id' => $horario['turno_id'],
                        ]);
                    }
                }
            }

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

            // Verificar si el usuario tiene datos laborales
            if (!$user->laborale) {
                throw new \Exception('El usuario no tiene datos laborales asignados.');
            }

            // Obtener el estado actual del usuario
            $estadoActivo = EstadoUser::where('nombre_estado', 'Activo')->first();
            $estadoInactivo = EstadoUser::where('nombre_estado', 'Inactivo')->first();

            if (!$estadoActivo || !$estadoInactivo) {
                throw new \Exception('No se encontraron los estados Activo/Inactivo en el sistema.');
            }

            // Determinar el nuevo estado
            $estadoActual = $user->laborale->estado_user_id;
            $nuevoEstado = ($estadoActual == $estadoActivo->id) ? $estadoInactivo->id : $estadoActivo->id;

            // Actualizar el estado del usuario
            $user->laborale->update(['estado_user_id' => $nuevoEstado]);

            // Determinar el mensaje según el nuevo estado
            $message = ($nuevoEstado == $estadoActivo->id) ? 'Usuario reestablecido exitosamente' : 'Usuario desactivado exitosamente';
            $action = ($nuevoEstado == $estadoActivo->id) ? 'reestablecido' : 'desactivado';

            DB::commit();

            /*Log::info("Usuario {$action}", [
                'user_id' => $user->id,
                'user_name' => $user->name,
                'nuevo_estado' => $nuevoEstado,
                'action_by' => auth()->id()
            ]);*/

            return redirect()->route('users.index')
                ->with('success', $message);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Error al cambiar estado del usuario", [
                'user_id' => $user->id,
                'error' => $e->getMessage()
            ]);
            return redirect()->route('users.index')
                ->with('error', 'Error al cambiar el estado del usuario: ' . $e->getMessage());
        }
    }
}
