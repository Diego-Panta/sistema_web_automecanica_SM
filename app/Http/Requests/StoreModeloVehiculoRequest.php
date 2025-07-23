<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreModeloVehiculoRequest extends FormRequest
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
            'marca_id' => 'required|exists:marca_vehiculos,id',
            'tipo_id' => 'required|exists:tipo_vehiculos,id',
            'nombre_modelo' => [
                'required',
                'string',
                'max:100',
                Rule::unique('modelo_vehiculos', 'nombre_modelo')->where(function ($query) {
                    return $query->where('marca_id', $this->marca_id);
                })
            ]
        ];
    }

    public function messages(): array
    {
        return [
            'marca_id.required' => 'La marca es obligatoria.',
            'marca_id.exists' => 'La marca seleccionada no es válida.',
            'tipo_id.required' => 'El tipo de vehículo es obligatorio.',
            'tipo_id.exists' => 'El tipo de vehículo seleccionado no es válido.',
            'nombre_modelo.required' => 'El nombre del modelo es obligatorio.',
            'nombre_modelo.string' => 'El nombre debe ser una cadena de texto.',
            'nombre_modelo.max' => 'El nombre no puede exceder los 100 caracteres.',
            'nombre_modelo.unique' => 'Este modelo ya existe para la marca seleccionada.'
        ];
    }

    public function attributes(): array
    {
        return [
            'marca_id' => 'marca',
            'tipo_id' => 'tipo de vehículo',
            'nombre_modelo' => 'nombre del modelo'
        ];
    }
}
