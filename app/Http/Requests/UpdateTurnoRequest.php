<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTurnoRequest extends FormRequest
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
            'nombre_turno' => [
                'required',
                'string',
                'max:50',
                Rule::unique('turnos', 'nombre_turno')->ignore($this->route('turno'))
            ],
            'hora_inicio' => 'required|date_format:H:i',
            'hora_fin' => 'required|date_format:H:i|after:hora_inicio'
        ];
    }

    public function messages(): array
    {
        return [
            'nombre_turno.required' => 'El nombre del turno es obligatorio.',
            'nombre_turno.string' => 'El nombre debe ser una cadena de texto.',
            'nombre_turno.max' => 'El nombre no puede exceder los 50 caracteres.',
            'nombre_turno.unique' => 'Este turno ya existe en el sistema.',
            'hora_inicio.required' => 'La hora de inicio es obligatoria.',
            'hora_inicio.date_format' => 'Formato de hora inválido (HH:MM).',
            'hora_fin.required' => 'La hora de fin es obligatoria.',
            'hora_fin.date_format' => 'Formato de hora inválido (HH:MM).',
            'hora_fin.after' => 'La hora de fin debe ser posterior a la hora de inicio.'
        ];
    }

    public function attributes(): array
    {
        return [
            'nombre_turno' => 'nombre del turno',
            'hora_inicio' => 'hora de inicio',
            'hora_fin' => 'hora de fin'
        ];
    }
}