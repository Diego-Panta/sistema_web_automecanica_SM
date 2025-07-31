<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreClienteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'estado_cliente_id' => 'required|exists:estado_clientes,id',
            'nombre' => 'required|string|max:100',
            'apellido_paterno' => 'required|string|max:50',
            'apellido_materno' => 'nullable|string|max:50',
            'dni' => 'nullable|string|size:8|unique:clientes,dni',
            'celular' => 'nullable|string|size:9',
            'celular_alterno' => 'nullable|string|size:9',
            'correo' => 'nullable|email|max:100',
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre es obligatorio.',
            'apellido_paterno.required' => 'El apellido paterno es obligatorio.',
            'dni.unique' => 'Este DNI ya está registrado.',
            'dni.size' => 'El DNI debe tener 8 caracteres.',
            'celular.size' => 'El celular debe tener 9 dígitos.',
            'celular_alterno.size' => 'El celular alterno debe tener 9 dígitos.',
            'correo.email' => 'El correo electrónico no es válido.',
            'estado_cliente_id.required' => 'El estado del cliente es obligatorio.',
        ];
    }
}