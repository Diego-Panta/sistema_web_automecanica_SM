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
        $rules = [
            // cliente_id se incluye como campo oculto para mantener la relación
            'cliente_id' => 'sometimes|exists:clientes,id',
            'canal_id' => 'required|exists:canales,id',
            'tipo_id' => 'required|exists:tipo_leads,id',
            'estado_actual_id' => 'required|exists:estado_leads,id',
            'resultado_id' => 'nullable|exists:resultado_leads,id',
            'medio_contacto_id' => 'nullable|exists:medio_contactos,id',
            'forma_registro_id' => 'required|exists:forma_registros,id',
            'marca_id' => 'nullable|exists:marca_vehiculos,id',
            'modelo_id' => 'nullable|exists:modelo_vehiculos,id',
            'tipo_servicio_id' => 'nullable|exists:tipo_servicios,id',
            'financiamiento' => 'nullable|boolean',
            'tiempo_compra' => 'nullable|string|max:100',
            'numero_placa_postventa' => 'nullable|string|max:10',
            'numero_placa_repuesto' => 'nullable|string|max:10',
            'kilometraje' => 'nullable|integer|min:0',
            'fecha_cita' => 'nullable|date',
            'horario_cita' => 'nullable|string|max:50',
            'observacion' => 'nullable|string',
            'consulta_postventa' => 'nullable|string',
            'consulta_repuesto' => 'nullable|string',
            'fecha_cierre' => 'nullable|date',
        ];

        // Validaciones condicionales según el tipo de lead actual
        $leadActual = $this->route('lead'); // Obtiene el lead desde la ruta
        if ($leadActual) {
            $tipoLead = $this->getTipoLeadActualizado($leadActual);

            if ($tipoLead === 'postventa') {
                $rules['numero_placa_postventa'] = 'required|string|max:10';
                $rules['kilometraje'] = 'required|integer|min:0';
                $rules['tipo_servicio_id'] = 'required|exists:tipo_servicios,id';
                $rules['fecha_cita'] = 'required|date';
                $rules['horario_cita'] = 'required|string|max:50';
                $rules['consulta_postventa'] = 'nullable|string';
            } elseif ($tipoLead === 'compra') {
                $rules['tiempo_compra'] = 'required|string|max:100';
                $rules['medio_contacto_id'] = 'required|exists:medio_contactos,id';
            } elseif ($tipoLead === 'repuesto') {
                $rules['numero_placa_repuesto'] = 'required|string|max:10';
                $rules['consulta_repuesto'] = 'nullable|string';
            }
        }

        return $rules;
    }

    private function getTipoLeadActualizado($lead): ?string
    {
        // Si se está cambiando el tipo, usar el nuevo tipo
        if ($this->has('tipo_id')) {
            try {
                $tipo = \App\Models\TipoLead::find($this->input('tipo_id'));
            } catch (\Exception $e) {
                return null;
            }
        } else {
            // Si no se cambia, usar el tipo actual del lead
            $tipo = $lead->tipo;
        }

        if (!$tipo) return null;

        $nombreTipo = strtolower($tipo->nombre_tipo);

        if (str_contains($nombreTipo, 'compra') || str_contains($nombreTipo, 'cotización')) {
            return 'compra';
        } elseif (str_contains($nombreTipo, 'postventa') || str_contains($nombreTipo, 'servicio')) {
            return 'postventa';
        } elseif (str_contains($nombreTipo, 'repuesto') || str_contains($nombreTipo, 'cotiza tu repuesto')) {
            return 'repuesto';
        }

        return null;
    }

    public function messages(): array
    {
        return [
            'cliente_id.exists' => 'El cliente seleccionado no existe.',
            'canal_id.required' => 'El canal es obligatorio.',
            'canal_id.exists' => 'El canal seleccionado no es válido.',
            'tipo_id.required' => 'El tipo de lead es obligatorio.',
            'tipo_id.exists' => 'El tipo de lead seleccionado no es válido.',
            'estado_actual_id.required' => 'El estado actual es obligatorio.',
            'estado_actual_id.exists' => 'El estado actual seleccionado no es válido.',
            'resultado_id.exists' => 'El resultado seleccionado no es válido.',
            'medio_contacto_id.exists' => 'El medio de contacto seleccionado no es válido.',
            'forma_registro_id.required' => 'La forma de registro es obligatoria.',
            'forma_registro_id.exists' => 'La forma de registro seleccionada no es válida.',
            'modelo_id.exists' => 'El modelo de vehículo seleccionado no es válido.',
            'tipo_servicio_id.exists' => 'El tipo de servicio seleccionado no es válido.',
            'financiamiento.boolean' => 'El campo financiamiento debe ser verdadero o falso.',
            'tiempo_compra.max' => 'El tiempo de compra no puede exceder los 100 caracteres.',
            'numero_placa_postventa.max' => 'El número de placa no puede exceder los 10 caracteres.',
            'numero_placa_repuesto.max' => 'El número de placa no puede exceder los 10 caracteres.',
            'numero_placa_postventa.required' => 'El número de placa es obligatorio para postventa.',
            'numero_placa_repuesto.required' => 'El número de placa es obligatorio para repuestos.',
            'kilometraje.integer' => 'El kilometraje debe ser un número entero.',
            'kilometraje.min' => 'El kilometraje no puede ser negativo.',
            'kilometraje.required' => 'El kilometraje es obligatorio para leads de postventa.',
            'fecha_cita.date' => 'La fecha de cita debe ser una fecha válida.',
            'fecha_cita.required' => 'La fecha de cita es obligatoria para leads de postventa.',
            'horario_cita.max' => 'El horario de cita no puede exceder los 50 caracteres.',
            'horario_cita.required' => 'El horario de cita es obligatorio para leads de postventa.',
            'tiempo_compra.required' => 'El tiempo de compra es obligatorio para leads de compra.',
            'fecha_cierre.date' => 'La fecha de cierre debe ser una fecha válida.',
        ];
    }
}
