<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreMarcaVehiculoRequest extends FormRequest
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
            'nombre_marca' => [
                'required',
                'string',
                'max:50',
                Rule::unique('marca_vehiculos', 'nombre_marca')
            ]
        ];
    }

    public function messages(): array
    {
        return [
            'nombre_marca.required' => 'El nombre de la marca es obligatorio.',
            'nombre_marca.string' => 'El nombre debe ser una cadena de texto.',
            'nombre_marca.max' => 'El nombre no puede exceder los 50 caracteres.',
            'nombre_marca.unique' => 'Esta marca ya existe en el sistema.'
        ];
    }

    public function attributes(): array
    {
        return [
            'nombre_marca' => 'nombre de la marca'
        ];
    }
}
