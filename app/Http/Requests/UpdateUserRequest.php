<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $userId = $this->route('user')->id;
        
        return [
            // Datos personales
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($userId)
            ],
            'password' => 'nullable|string|min:8|confirmed',
            'dni' => [
                'nullable',
                'string',
                'size:8',
                'regex:/^[0-9]{8}$/',
                Rule::unique('users')->ignore($userId)
            ],
            'celular' => 'required|string|size:9|regex:/^9[0-9]{8}$/',
            'celular_alterno' => 'nullable|string|size:9|regex:/^9[0-9]{8}$/',
            'email_personal' => 'nullable|email',
            'fecha_nacimiento' => 'nullable|date',
            'direccion' => 'nullable|string|max:255',
            
            // Datos laborales (AGREGAR SEDE_ID)
            'sede_id' => 'required|exists:sedes,id', // NUEVO
            'estado_user_id' => 'nullable|exists:estado_users,id',
            'codigo_trabajador' => [
                'required',
                'string',
                'max:20',
                Rule::unique('user_laborales')->ignore($userId, 'user_id')
            ],
            'fecha_contratacion_inicio' => 'required|date',
            'fecha_contratacion_fin' => 'nullable|date|after_or_equal:fecha_contratacion_inicio',
            
            // Horarios (ELIMINAR SEDE_ID DE HORARIOS)
            'horarios' => 'nullable|array',
            'horarios.*.dia_semana' => 'required|string|in:lunes,martes,miercoles,jueves,viernes,sabado,domingo',
            'horarios.*.turno_id' => 'required|exists:turnos,id',
            
            // Roles
            'roles' => 'nullable|array',
            'roles.*' => 'exists:roles,id'
        ];
    }

    public function messages(): array
    {
        return [
            // Mensajes para datos personales
            'name.required' => 'El nombre completo es obligatorio.',
            'email.required' => 'El correo corporativo es obligatorio.',
            'email.unique' => 'Este correo corporativo ya está registrado.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
            'dni.size' => 'El DNI debe tener 8 dígitos.',
            'dni.regex' => 'El DNI debe contener solo números.',
            'dni.unique' => 'Este DNI ya está registrado.',
            'celular.required' => 'El número celular es obligatorio.',
            'celular.size' => 'El celular debe tener 9 dígitos.',
            'celular.regex' => 'El celular debe comenzar con 9 y tener 8 dígitos más.',
            'celular_alterno.size' => 'El celular alterno debe tener 9 dígitos.',
            'celular_alterno.regex' => 'El celular alterno debe comenzar con 9 y tener 8 dígitos más.',
            'email_personal.email' => 'El correo personal debe ser una dirección válida.',
            
            // Mensajes para datos laborales (AGREGAR MENSAJE PARA SEDE)
            'sede_id.required' => 'La sede es obligatoria.', // NUEVO
            'sede_id.exists' => 'La sede seleccionada no es válida.', // NUEVO
            'codigo_trabajador.required' => 'El código de trabajador es obligatorio.',
            'codigo_trabajador.unique' => 'Este código de trabajador ya está registrado.',
            'fecha_contratacion_inicio.required' => 'La fecha de inicio de contrato es obligatoria.',
            'fecha_contratacion_fin.after_or_equal' => 'La fecha de fin debe ser igual o posterior a la fecha de inicio.',
            
            // Mensajes para horarios (ELIMINAR MENSAJES DE SEDE)
            'horarios.*.dia_semana.required' => 'El día de la semana es obligatorio en cada asignación.',
            'horarios.*.dia_semana.in' => 'El día de la semana seleccionado no es válido.',
            'horarios.*.turno_id.required' => 'El turno es obligatorio en cada asignación.',
            'horarios.*.turno_id.exists' => 'El turno seleccionado no es válido.',
            
            // Mensajes para relaciones
            'estado_user_id.exists' => 'El estado de usuario seleccionado no es válido.',
            
            // Roles
            'roles.*.exists' => 'Uno o más roles seleccionados no son válidos.'
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'nombre completo',
            'email' => 'correo corporativo',
            'dni' => 'DNI',
            'celular' => 'número celular',
            'celular_alterno' => 'celular alterno',
            'email_personal' => 'correo personal',
            'fecha_nacimiento' => 'fecha de nacimiento',
            'direccion' => 'dirección',
            'sede_id' => 'sede', // NUEVO
            'codigo_trabajador' => 'código de trabajador',
            'fecha_contratacion_inicio' => 'fecha de inicio de contrato',
            'fecha_contratacion_fin' => 'fecha de fin de contrato'
        ];
    }
}