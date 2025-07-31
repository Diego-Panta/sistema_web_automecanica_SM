<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateLeadRequest extends FormRequest
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
            'cliente_id' => 'required|exists:clientes,id',
            'canal_id' => 'required|exists:canales,id',
            'tipo_id' => 'required|exists:tipo_leads,id',
            'estado_actual_id' => 'required|exists:estado_leads,id',
            'resultado_id' => 'nullable|exists:resultado_leads,id',
            'medio_contacto_id' => 'required|exists:medio_contactos,id',
            'forma_registro_id' => 'required|exists:forma_registros,id',
            'modelo_id' => 'nullable|exists:modelo_vehiculos,id',
            'financiamiento' => 'boolean',
            'tiempo_compra' => 'nullable|string|max:100',
            'observacion' => 'nullable|string',
            'fecha_cierre' => 'nullable|date',
        ];
    }

    public function messages(): array
    {
        return [
            'cliente_id.required' => 'El cliente es obligatorio.',
            'canal_id.required' => 'El canal es obligatorio.',
            'tipo_id.required' => 'El tipo de lead es obligatorio.',
            'estado_actual_id.required' => 'El estado actual es obligatorio.',
            'medio_contacto_id.required' => 'El medio de contacto es obligatorio.',
            'forma_registro_id.required' => 'La forma de registro es obligatoria.',
            '*.exists' => 'El valor seleccionado no es válido.',
        ];
    }
}
