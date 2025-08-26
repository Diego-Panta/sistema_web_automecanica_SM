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
            // cliente_id se incluye como campo oculto para mantener la relación
            'cliente_id' => 'sometimes|exists:clientes,id',
            'canal_id' => 'required|exists:canales,id',
            'tipo_id' => 'required|exists:tipo_leads,id',
            'estado_actual_id' => 'required|exists:estado_leads,id',
            'resultado_id' => 'nullable|exists:resultado_leads,id',
            'medio_contacto_id' => 'required|exists:medio_contactos,id',
            'forma_registro_id' => 'required|exists:forma_registros,id',
            'modelo_id' => 'nullable|exists:modelo_vehiculos,id',
            'tipo_servicio_id' => 'nullable|exists:tipo_servicios,id',
            'financiamiento' => 'boolean',
            'tiempo_compra' => 'nullable|string|max:100',
            'numero_placa' => 'nullable|string|max:10',
            'kilometraje' => 'nullable|integer|min:0',
            'fecha_cita' => 'nullable|date',
            'horario_cita' => 'nullable|string|max:50',
            'observacion' => 'nullable|string',
            'fecha_cierre' => 'nullable|date',
        ];
    }

    public function messages(): array
    {
        return [
            'canal_id.required' => 'El canal es obligatorio.',
            'tipo_id.required' => 'El tipo de lead es obligatorio.',
            'estado_actual_id.required' => 'El estado actual es obligatorio.',
            'medio_contacto_id.required' => 'El medio de contacto es obligatorio.',
            'forma_registro_id.required' => 'La forma de registro es obligatoria.',
            'tipo_servicio_id.exists' => 'El tipo de servicio seleccionado no es válido.',
            'numero_placa.max' => 'El número de placa no puede exceder los 10 caracteres.',
            'kilometraje.integer' => 'El kilometraje debe ser un número entero.',
            'kilometraje.min' => 'El kilometraje no puede ser negativo.',
            'fecha_cita.date' => 'La fecha de cita debe ser una fecha válida.',
            'horario_cita.max' => 'El horario de cita no puede exceder los 50 caracteres.',
            '*.exists' => 'El valor seleccionado no es válido.',
        ];
    }
}
