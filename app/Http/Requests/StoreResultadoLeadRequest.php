<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreResultadoLeadRequest extends FormRequest
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
            'nombre_resultado' => [
                'required',
                'string',
                'max:50',
                Rule::unique('resultado_leads', 'nombre_resultado')
            ]
        ];
    }

    public function messages(): array
    {
        return [
            'nombre_resultado.required' => 'El nombre del resultado es obligatorio.',
            'nombre_resultado.string' => 'El nombre debe ser una cadena de texto.',
            'nombre_resultado.max' => 'El nombre no puede exceder los 50 caracteres.',
            'nombre_resultado.unique' => 'Este resultado ya existe en el sistema.'
        ];
    }

    public function attributes(): array
    {
        return [
            'nombre_resultado' => 'nombre del resultado'
        ];
    }
}
