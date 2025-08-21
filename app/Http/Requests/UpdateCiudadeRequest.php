<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCiudadeRequest extends FormRequest
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
            'nombre' => [
                'required',
                'string',
                'max:100',
                Rule::unique('ciudades', 'nombre')->ignore($this->route('ciudad'))
            ],
            'region' => 'nullable|string|max:100'
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre de la ciudad es obligatorio.',
            'nombre.string' => 'El nombre debe ser una cadena de texto.',
            'nombre.max' => 'El nombre no puede exceder los 100 caracteres.',
            'nombre.unique' => 'Esta ciudad ya existe en el sistema.',
            'region.string' => 'La región debe ser texto.',
            'region.max' => 'La región no puede exceder los 100 caracteres.'
        ];
    }

    public function attributes(): array
    {
        return [
            'nombre' => 'nombre de la ciudad',
            'region' => 'región'
        ];
    }
}
