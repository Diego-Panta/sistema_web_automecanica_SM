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
            'medio_contacto_id' => 'nullable|exists:medio_contactos,id',
            'forma_registro_id' => 'required|exists:forma_registros,id',
            'marca_id' => 'nullable|exists:marca_vehiculos,id',
            'financiamiento' => 'nullable|boolean',
            'tiempo_compra' => 'nullable|string|max:100',
            'observacion' => 'nullable|string',

            // Campos específicos de leads (nuevos en migración)
            'tipo_servicio_id' => 'nullable|exists:tipo_servicios,id',
            'numero_placa_postventa' => 'nullable|string|max:10',
            'numero_placa_repuesto' => 'nullable|string|max:10',
            'kilometraje' => 'nullable|integer|min:0',
            'fecha_cita' => 'nullable|date',
            'horario_cita' => 'nullable|string|max:50',
            'consulta_postventa' => 'nullable|string',
            'consulta_repuesto' => 'nullable|string',
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
            $rules['tipo_documento_id'] = 'required|exists:tipo_documentos,id';
            $rules['numero_documento'] = 'required|string|max:20|unique:clientes,numero_documento';
            $rules['celular'] = 'nullable|string|size:9';
            $rules['celular_alterno'] = 'nullable|string|size:9';
            $rules['correo'] = 'nullable|email|max:100';
            $rules['estado_cliente_id'] = 'required|exists:estado_clientes,id';
        }

        // Validaciones condicionales según el tipo de lead
        $tipoLead = $this->getTipoLeadSeleccionado();

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

        return $rules;
    }

    private function getTipoLeadSeleccionado(): ?string
    {
        if (!$this->has('tipo_id')) {
            return null;
        }

        // Aquí puedes obtener el tipo basado en el tipo_id
        // Por simplicidad, asumimos que tienes acceso a los tipos
        $tipoId = $this->input('tipo_id');

        // Puedes usar un query para obtener el tipo, pero para evitar queries en validation
        // podrías usar un approach más directo basado en IDs conocidos o usar Cache
        try {
            $tipo = \App\Models\TipoLead::find($tipoId);
            if (!$tipo) return null;

            $nombreTipo = strtolower($tipo->nombre_tipo);

            if (str_contains($nombreTipo, 'compra') || str_contains($nombreTipo, 'cotización')) {
                return 'compra';
            } elseif (str_contains($nombreTipo, 'postventa') || str_contains($nombreTipo, 'servicio')) {
                return 'postventa';
            } elseif (str_contains($nombreTipo, 'repuesto') || str_contains($nombreTipo, 'cotiza tu repuesto')) {
                return 'repuesto';
            }
        } catch (\Exception $e) {
            // En caso de error, retorna null para no bloquear la validación
            return null;
        }

        return null;
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
            'tipo_documento_id.required' => 'El tipo de documento es obligatorio.',
            'tipo_documento_id.exists' => 'El tipo de documento seleccionado no es válido.',
            'numero_documento.unique' => 'Este número de documento ya está registrado.',
            'numero_documento.max' => 'El número de documento no puede exceder los 20 caracteres.',
            'celular.size' => 'El celular debe tener 9 dígitos.',
            'celular_alterno.size' => 'El celular alterno debe tener 9 dígitos.',
            'correo.email' => 'El correo electrónico no es válido.',
            'estado_cliente_id.required' => 'El estado del cliente es obligatorio.',
            'canal_id.required' => 'El canal es obligatorio.',
            'tipo_id.required' => 'El tipo de lead es obligatorio.',
            'estado_actual_id.required' => 'El estado actual es obligatorio.',
            'forma_registro_id.required' => 'La forma de registro es obligatoria.',
            'tipo_servicio_id.exists' => 'El tipo de servicio seleccionado no es válido.',
            'tipo_servicio_id.required' => 'El tipo de servicio es obligatorio para leads de postventa.',
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
            '*.exists' => 'El valor seleccionado no es válido.',
        ];
    }
}
