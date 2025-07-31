<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreLeadRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // Datos del Cliente
            'nombre' => 'required|string|max:100',
            'apellido_paterno' => 'required|string|max:50',
            'apellido_materno' => 'nullable|string|max:50',
            'dni' => 'nullable|string|size:8|unique:clientes,dni',
            'celular' => 'nullable|string|size:9',
            'celular_alterno' => 'nullable|string|size:9',
            'correo' => 'nullable|email|max:100',
            'estado_cliente_id' => 'required|exists:estado_clientes,id',
            
            // Datos del Lead
            'canal_id' => 'required|exists:canales,id',
            'tipo_id' => 'required|exists:tipo_leads,id',
            'estado_actual_id' => 'required|exists:estado_leads,id',
            'medio_contacto_id' => 'required|exists:medio_contactos,id',
            'forma_registro_id' => 'required|exists:forma_registros,id',
            'modelo_id' => 'nullable|exists:modelo_vehiculos,id',
            'financiamiento' => 'boolean',
            'tiempo_compra' => 'nullable|string|max:100',
            'observacion' => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre del cliente es obligatorio.',
            'apellido_paterno.required' => 'El apellido paterno es obligatorio.',
            'dni.unique' => 'Este DNI ya está registrado.',
            'dni.size' => 'El DNI debe tener 8 caracteres.',
            'celular.size' => 'El celular debe tener 9 dígitos.',
            'celular_alterno.size' => 'El celular alterno debe tener 9 dígitos.',
            'correo.email' => 'El correo electrónico no es válido.',
            'estado_cliente_id.required' => 'El estado del cliente es obligatorio.',
            'canal_id.required' => 'El canal es obligatorio.',
            'tipo_id.required' => 'El tipo de lead es obligatorio.',
            'estado_actual_id.required' => 'El estado actual es obligatorio.',
            'medio_contacto_id.required' => 'El medio de contacto es obligatorio.',
            'forma_registro_id.required' => 'La forma de registro es obligatoria.',
            '*.exists' => 'El valor seleccionado no es válido.',
        ];
    }
}