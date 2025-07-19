<?php

namespace App\Http\Requests;
use Illuminate\Validation\Rule;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEstadoLeadRequest extends FormRequest
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
            'nombre_estado' => [
                'required',
                'string',
                'max:50',
                Rule::unique('estado_leads', 'nombre_estado')->ignore($this->route('estado'))
            ]
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'nombre_estado.required' => 'El nombre del estado es obligatorio.',
            'nombre_estado.string' => 'El nombre debe ser una cadena de texto.',
            'nombre_estado.max' => 'El nombre no puede exceder los 50 caracteres.',
            'nombre_estado.unique' => 'Este estado ya existe en el sistema.'
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'nombre_estado' => 'nombre del estado'
        ];
    }
}