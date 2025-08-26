<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateClienteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'estado_cliente_id' => 'required|exists:estado_clientes,id',
            'nombre' => 'required|string|max:100',
            'apellido_paterno' => 'required|string|max:50',
            'apellido_materno' => 'nullable|string|max:50',
            'tipo_documento_id' => 'required|exists:tipo_documentos,id',
            'numero_documento' => 'nullable|string|max:20|unique:clientes,numero_documento,'.$this->cliente->id,
            'celular' => 'nullable|string|size:9',
            'celular_alterno' => 'nullable|string|size:9',
            'correo' => 'nullable|email|max:100',
        ];
    }
}