<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Permission;

class UpdatePermissionRequest extends FormRequest
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
        $permission = $this->route('permission');
        
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('permissions', 'name')->where(function ($query) {
                    return $query->where('guard_name', $this->guard_name ?? 'web');
                })->ignore($permission->id)
            ],
            'guard_name' => 'required|string|in:web,api',
            'description' => 'nullable|string|max:255'
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'El nombre del permiso es obligatorio.',
            'name.unique' => 'Este nombre de permiso ya está en uso.',
            'guard_name.required' => 'El guard name es obligatorio.',
            'guard_name.in' => 'El guard name debe ser web o api.'
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'nombre del permiso',
            'guard_name' => 'guard name',
            'description' => 'descripción'
        ];
    }
}
