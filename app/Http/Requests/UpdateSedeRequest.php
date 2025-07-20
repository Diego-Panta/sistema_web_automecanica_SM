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
            'nombre_sede' => [
                'required',
                'string',
                'max:100',
                Rule::unique('sedes', 'nombre_sede')->ignore($this->route('estado'))
            ],
            'direccion' => 'required|string|max:255',
            'capacidad' => 'nullable|integer|min:1'
        ];
    }

    public function messages(): array
    {
        return [
            'nombre_sede.required' => 'El nombre de la sede es obligatorio.',
            'nombre_sede.string' => 'El nombre debe ser una cadena de texto.',
            'nombre_sede.max' => 'El nombre no puede exceder los 100 caracteres.',
            'nombre_sede.unique' => 'Esta sede ya existe en el sistema.',
            'direccion.required' => 'La dirección es obligatoria.',
            'direccion.string' => 'La dirección debe ser texto.',
            'direccion.max' => 'La dirección no puede exceder los 255 caracteres.',
            'capacidad.integer' => 'La capacidad debe ser un número entero.',
            'capacidad.min' => 'La capacidad mínima es 1.'
        ];
    }

    public function attributes(): array
    {
        return [
            'nombre_sede' => 'nombre de la sede',
            'direccion' => 'dirección',
            'capacidad' => 'capacidad'
        ];
    }
}