@extends('adminlte::page')

@section('title', 'Asignar Permisos al Rol: ' . $role->name)

@section('content_header')
    <h1>Asignar Permisos al Rol: {{ $role->name }}</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('users.role-permissions.update', $role) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="form-group">
                    <label>Permisos Disponibles</label>
                    <div class="row">
                        @foreach($permissions as $permission)
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" 
                                           name="permissions[]" value="{{ $permission->id }}" 
                                           id="permission_{{ $permission->id }}"
                                           {{ in_array($permission->id, $role->permissions->pluck('id')->toArray()) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="permission_{{ $permission->id }}">
                                        {{ $permission->name }}
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @error('permissions')
                        <span class="text-danger" style="font-size: 0.875em;">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                
                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('users.roles') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Regresar
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Guardar Asignación
                    </button>
                </div>
            </form>
        </div>
    </div>
@stop