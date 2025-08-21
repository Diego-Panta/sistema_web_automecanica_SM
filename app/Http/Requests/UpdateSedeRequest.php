<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSedeRequest extends FormRequest
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
            'codigo_sede' => [
                'required',
                'string',
                'max:50',
                Rule::unique('sedes', 'codigo_sede')->ignore($this->route('sede'))
            ],
            'nombre_sede' => 'required|string|max:255',
            'ciudad_id' => 'required|exists:ciudades,id',
            'direccion' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'capacidad' => 'nullable|integer|min:1'
        ];
    }

    public function messages(): array
    {
        return [
            'codigo_sede.required' => 'El código de sede es obligatorio.',
            'codigo_sede.string' => 'El código debe ser texto.',
            'codigo_sede.max' => 'El código no puede exceder 50 caracteres.',
            'codigo_sede.unique' => 'Este código de sede ya existe.',
            'nombre_sede.required' => 'El nombre de la sede es obligatorio.',
            'nombre_sede.string' => 'El nombre debe ser texto.',
            'nombre_sede.max' => 'El nombre no puede exceder 255 caracteres.',
            'ciudad_id.required' => 'La ciudad es obligatoria.',
            'ciudad_id.exists' => 'La ciudad seleccionada no es válida.',
            'direccion.required' => 'La dirección es obligatoria.',
            'direccion.string' => 'La dirección debe ser texto.',
            'direccion.max' => 'La dirección no puede exceder 255 caracteres.',
            'descripcion.string' => 'La descripción debe ser texto.',
            'capacidad.integer' => 'La capacidad debe ser un número entero.',
            'capacidad.min' => 'La capacidad mínima es 1.'
        ];
    }

    public function attributes(): array
    {
        return [
            'codigo_sede' => 'código de sede',
            'nombre_sede' => 'nombre de la sede',
            'ciudad_id' => 'ciudad',
            'direccion' => 'dirección',
            'descripcion' => 'descripción',
            'capacidad' => 'capacidad'
        ];
    }
}