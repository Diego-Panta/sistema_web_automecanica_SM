<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCanaleRequest extends FormRequest
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
            'nombre_canal' => [
                'required',
                'string',
                'max:100',
                Rule::unique('canales', 'nombre_canal')
            ]
        ];
    }

    public function messages(): array
    {
        return [
            'nombre_canal.required' => 'El nombre del canal es obligatorio.',
            'nombre_canal.string' => 'El nombre debe ser una cadena de texto.',
            'nombre_canal.max' => 'El nombre no puede exceder los 100 caracteres.',
            'nombre_canal.unique' => 'Este canal ya existe en el sistema.'
        ];
    }

    public function attributes(): array
    {
        return [
            'nombre_canal' => 'nombre del canal'
        ];
    }
}