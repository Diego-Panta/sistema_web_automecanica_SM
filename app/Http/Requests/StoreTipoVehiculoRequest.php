<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTipoVehiculoRequest extends FormRequest
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
            'nombre_tipo_vehiculo' => [
                'required',
                'string',
                'max:50',
                Rule::unique('tipo_vehiculos', 'nombre_tipo_vehiculo')
            ]
        ];
    }

    public function messages(): array
    {
        return [
            'nombre_tipo_vehiculo.required' => 'El nombre del tipo de vehículo es obligatorio.',
            'nombre_tipo_vehiculo.string' => 'El nombre debe ser una cadena de texto.',
            'nombre_tipo_vehiculo.max' => 'El nombre no puede exceder los 50 caracteres.',
            'nombre_tipo_vehiculo.unique' => 'Este tipo de vehículo ya existe en el sistema.'
        ];
    }

    public function attributes(): array
    {
        return [
            'nombre_tipo_vehiculo' => 'nombre del tipo de vehículo'
        ];
    }
}
