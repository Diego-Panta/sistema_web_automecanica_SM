<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreFormaRegistroRequest extends FormRequest
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
            'nombre_forma' => [
                'required',
                'string',
                'max:50',
                Rule::unique('forma_registros', 'nombre_forma')
            ]
        ];
    }

    public function messages(): array
    {
        return [
            'nombre_forma.required' => 'El nombre de la forma de registro es obligatorio.',
            'nombre_forma.string' => 'El nombre debe ser una cadena de texto.',
            'nombre_forma.max' => 'El nombre no puede exceder los 50 caracteres.',
            'nombre_forma.unique' => 'Esta forma de registro ya existe en el sistema.'
        ];
    }

    public function attributes(): array
    {
        return [
            'nombre_forma' => 'nombre de la forma de registro'
        ];
    }
}
