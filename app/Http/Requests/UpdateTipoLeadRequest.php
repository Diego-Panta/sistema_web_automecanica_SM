<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateTipoLeadRequest extends FormRequest
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
            'nombre_tipo' => [
                'required',
                'string',
                'max:50',
                Rule::unique('tipo_leads', 'nombre_tipo')->ignore($this->route('tipo'))
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
            'nombre_tipo.required' => 'El nombre del tipo de lead es obligatorio.',
            'nombre_tipo.string' => 'El nombre debe ser una cadena de texto.',
            'nombre_tipo.max' => 'El nombre no puede exceder los 50 caracteres.',
            'nombre_tipo.unique' => 'Este tipo de lead ya existe en el sistema.'
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
            'nombre_tipo' => 'nombre del tipo de lead'
        ];
    }
}
