@extends('adminlte::page')

@section('title', 'Crear Nuevo Rol')

@section('content_header')
    <h1>Crear Nuevo Rol</h1>
@stop

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <form action="{{ route('users.roles.store') }}" method="POST">
                @csrf
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">Nombre del Rol*</label>
                            <input type="text" name="name" id="name" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   value="{{ old('name') }}" required>
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="guard_name">Guard Name*</label>
                            <select name="guard_name" id="guard_name" 
                                    class="form-control @error('guard_name') is-invalid @enderror" required>
                                <option value="web" {{ old('guard_name', 'web') == 'web' ? 'selected' : '' }}>Web</option>
                                <option value="api" {{ old('guard_name') == 'api' ? 'selected' : '' }}>API</option>
                            </select>
                            @error('guard_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <div class="form-group mt-4">
                    <label>Asignar Permisos</label>
                    @if($permissions->isEmpty())
                        <div class="alert alert-warning">
                            No hay permisos disponibles. Primero crea algunos permisos.
                        </div>
                    @else
                        <div class="row">
                            @foreach($permissions as $permission)
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" 
                                               name="permissions[]" value="{{ $permission->id }}" 
                                               id="permission_{{ $permission->id }}"
                                               {{ in_array($permission->id, old('permissions', [])) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="permission_{{ $permission->id }}">
                                            {{ $permission->name }} ({{ $permission->guard_name }})
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
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
                        <i class="fas fa-save"></i> Guardar Rol
                    </button>
                </div>
            </form>
        </div>
    </div>
@stop