<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreAccioneRequest extends FormRequest
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
            'nombre_accion' => [
                'required',
                'string',
                'max:100',
                Rule::unique('acciones', 'nombre_accion')
            ],
            'descripcion' => 'nullable|string|max:255'
        ];
    }

    public function messages(): array
    {
        return [
            'nombre_accion.required' => 'El nombre de la acción es obligatorio.',
            'nombre_accion.string' => 'El nombre debe ser una cadena de texto.',
            'nombre_accion.max' => 'El nombre no puede exceder los 100 caracteres.',
            'nombre_accion.unique' => 'Esta acción ya existe en el sistema.',
            'descripcion.string' => 'La descripción debe ser texto.',
            'descripcion.max' => 'La descripción no puede exceder los 255 caracteres.'
        ];
    }

    public function attributes(): array
    {
        return [
            'nombre_accion' => 'nombre de la acción',
            'descripcion' => 'descripción'
        ];
    }
}
