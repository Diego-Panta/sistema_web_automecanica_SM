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
        $rules = [
            // Campo de selección de tipo de cliente
            'tipo_cliente' => 'required|in:existente,nuevo',
            
            // Datos del Lead (siempre requeridos)
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

        // Si es cliente existente, validar cliente_id
        if ($this->input('tipo_cliente') === 'existente') {
            $rules['cliente_id'] = 'required|exists:clientes,id';
        }

        // Si es nuevo cliente, validar campos del cliente
        if ($this->input('tipo_cliente') === 'nuevo') {
            $rules['nombre'] = 'required|string|max:100';
            $rules['apellido_paterno'] = 'required|string|max:50';
            $rules['apellido_materno'] = 'nullable|string|max:50';
            $rules['dni'] = 'nullable|string|size:8|unique:clientes,dni';
            $rules['celular'] = 'nullable|string|size:9';
            $rules['celular_alterno'] = 'nullable|string|size:9';
            $rules['correo'] = 'nullable|email|max:100';
            $rules['estado_cliente_id'] = 'required|exists:estado_clientes,id';
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'tipo_cliente.required' => 'Debe seleccionar el tipo de cliente.',
            'tipo_cliente.in' => 'El tipo de cliente seleccionado no es válido.',
            'cliente_id.required' => 'Debe seleccionar un cliente existente.',
            'cliente_id.exists' => 'El cliente seleccionado no existe.',
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