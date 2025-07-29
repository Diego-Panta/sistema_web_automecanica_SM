<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

class UpdateRoleRequest extends FormRequest
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
        $role = $this->route('role');
        
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('roles', 'name')->where(function ($query) {
                    return $query->where('guard_name', $this->guard_name ?? 'web');
                })->ignore($role->id)
            ],
            'guard_name' => 'required|string|in:web,api',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id'
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'El nombre del rol es obligatorio.',
            'name.unique' => 'Este nombre de rol ya está en uso.',
            'guard_name.required' => 'El guard name es obligatorio.',
            'guard_name.in' => 'El guard name debe ser web o api.',
            'permissions.*.exists' => 'Uno o más permisos seleccionados no son válidos.'
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'nombre del rol',
            'guard_name' => 'guard name'
        ];
    }
}
