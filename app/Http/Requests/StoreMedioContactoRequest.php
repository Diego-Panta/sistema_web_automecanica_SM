<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreMedioContactoRequest extends FormRequest
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
            'nombre_medio' => [
                'required',
                'string',
                'max:50',
                Rule::unique('medio_contactos', 'nombre_medio')
            ],
            'descripcion' => 'nullable|string|max:255'
        ];
    }

    public function messages(): array
    {
        return [
            'nombre_medio.required' => 'El nombre del medio de contacto es obligatorio.',
            'nombre_medio.string' => 'El nombre debe ser una cadena de texto.',
            'nombre_medio.max' => 'El nombre no puede exceder los 50 caracteres.',
            'nombre_medio.unique' => 'Este medio de contacto ya existe en el sistema.',
            'descripcion.string' => 'La descripción debe ser texto.',
            'descripcion.max' => 'La descripción no puede exceder los 255 caracteres.'
        ];
    }

    public function attributes(): array
    {
        return [
            'nombre_medio' => 'nombre del medio de contacto',
            'descripcion' => 'descripción'
        ];
    }
}