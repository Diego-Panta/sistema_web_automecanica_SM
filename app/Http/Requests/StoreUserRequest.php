<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
     public function rules(): array
    {
        return [
            // Datos personales
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'dni' => 'nullable|string|size:8|regex:/^[0-9]{8}$/|unique:users',
            'celular' => 'required|string|size:9|regex:/^9[0-9]{8}$/',
            'celular_alterno' => 'nullable|string|size:9|regex:/^9[0-9]{8}$/',
            'email_personal' => 'nullable|email',
            'fecha_nacimiento' => 'nullable|date',
            'direccion' => 'nullable|string|max:255',
            
            // Datos laborales
            'turno_id' => 'nullable|exists:turnos,id',
            'sede_id' => 'nullable|exists:sedes,id',
            'estado_user_id' => 'nullable|exists:estado_users,id',
            'codigo_trabajador' => 'required|string|max:20|unique:user_laborales',
            'fecha_contratacion_inicio' => 'required|date',
            'fecha_contratacion_fin' => 'nullable|date|after_or_equal:fecha_contratacion_inicio',
            
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
            'password.required' => 'La contraseña es obligatoria.',
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
            
            // Mensajes para datos laborales
            'codigo_trabajador.required' => 'El código de trabajador es obligatorio.',
            'codigo_trabajador.unique' => 'Este código de trabajador ya está registrado.',
            'fecha_contratacion_inicio.required' => 'La fecha de inicio de contrato es obligatoria.',
            'fecha_contratacion_fin.after_or_equal' => 'La fecha de fin debe ser igual o posterior a la fecha de inicio.',
            
            // Mensajes para relaciones
            'turno_id.exists' => 'El turno seleccionado no es válido.',
            'sede_id.exists' => 'La sede seleccionada no es válida.',
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
            'codigo_trabajador' => 'código de trabajador',
            'fecha_contratacion_inicio' => 'fecha de inicio de contrato',
            'fecha_contratacion_fin' => 'fecha de fin de contrato'
        ];
    }
}
