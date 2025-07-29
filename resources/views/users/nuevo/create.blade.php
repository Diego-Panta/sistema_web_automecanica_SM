@extends('adminlte::page')

@section('title', 'Crear Nuevo Usuario')

@section('content_header')
    <h1>Crear Nuevo Usuario</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('users.store') }}" method="POST">
                @csrf
                
                <div class="row">
                    <div class="col-md-6">
                        <h4 class="mb-4">Datos Personales</h4>
                        
                        <div class="form-group">
                            <label for="name">Nombre Completo*</label>
                            <input type="text" name="name" id="name" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   value="{{ old('name') }}" required>
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="email">Correo Corporativo*</label>
                            <input type="email" name="email" id="email" 
                                   class="form-control @error('email') is-invalid @enderror" 
                                   value="{{ old('email') }}" required>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="password">Contraseña*</label>
                                    <input type="password" name="password" id="password" 
                                           class="form-control @error('password') is-invalid @enderror" required>
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="password_confirmation">Confirmar Contraseña*</label>
                                    <input type="password" name="password_confirmation" id="password_confirmation" 
                                           class="form-control" required>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="dni">DNI</label>
                            <input type="text" name="dni" id="dni" 
                                   class="form-control @error('dni') is-invalid @enderror" 
                                   value="{{ old('dni') }}" 
                                   placeholder="8 dígitos">
                            @error('dni')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="celular">Celular*</label>
                            <input type="text" name="celular" id="celular" 
                                   class="form-control @error('celular') is-invalid @enderror" 
                                   value="{{ old('celular') }}" required
                                   placeholder="9 dígitos, comienza con 9">
                            @error('celular')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <h4 class="mb-4">Datos Laborales</h4>
                        
                        <div class="form-group">
                            <label for="codigo_trabajador">Código de Trabajador*</label>
                            <input type="text" name="codigo_trabajador" id="codigo_trabajador" 
                                   class="form-control @error('codigo_trabajador') is-invalid @enderror" 
                                   value="{{ old('codigo_trabajador') }}" required>
                            @error('codigo_trabajador')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="sede_id">Sede</label>
                                    <select name="sede_id" id="sede_id" 
                                            class="form-control @error('sede_id') is-invalid @enderror">
                                        <option value="">Seleccione una sede</option>
                                        @foreach($sedes as $sede)
                                            <option value="{{ $sede->id }}" {{ old('sede_id') == $sede->id ? 'selected' : '' }}>
                                                {{ $sede->nombre_sede }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('sede_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="turno_id">Turno</label>
                                    <select name="turno_id" id="turno_id" 
                                            class="form-control @error('turno_id') is-invalid @enderror">
                                        <option value="">Seleccione un turno</option>
                                        @foreach($turnos as $turno)
                                            <option value="{{ $turno->id }}" {{ old('turno_id') == $turno->id ? 'selected' : '' }}>
                                                {{ $turno->nombre_turno }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('turno_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="estado_user_id">Estado</label>
                            <select name="estado_user_id" id="estado_user_id" 
                                    class="form-control @error('estado_user_id') is-invalid @enderror">
                                <option value="">Seleccione un estado</option>
                                @foreach($estados as $estado)
                                    <option value="{{ $estado->id }}" {{ old('estado_user_id') == $estado->id ? 'selected' : '' }}>
                                        {{ $estado->nombre_estado }}
                                    </option>
                                @endforeach
                            </select>
                            @error('estado_user_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="fecha_contratacion_inicio">Fecha Inicio Contrato*</label>
                                    <input type="date" name="fecha_contratacion_inicio" id="fecha_contratacion_inicio" 
                                           class="form-control @error('fecha_contratacion_inicio') is-invalid @enderror" 
                                           value="{{ old('fecha_contratacion_inicio') }}" required>
                                    @error('fecha_contratacion_inicio')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="fecha_contratacion_fin">Fecha Fin Contrato</label>
                                    <input type="date" name="fecha_contratacion_fin" id="fecha_contratacion_fin" 
                                           class="form-control @error('fecha_contratacion_fin') is-invalid @enderror" 
                                           value="{{ old('fecha_contratacion_fin') }}">
                                    @error('fecha_contratacion_fin')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row mt-4">
                    <div class="col-md-6">
                        <h4 class="mb-4">Información Adicional</h4>
                        
                        <div class="form-group">
                            <label for="celular_alterno">Celular Alterno</label>
                            <input type="text" name="celular_alterno" id="celular_alterno" 
                                   class="form-control @error('celular_alterno') is-invalid @enderror" 
                                   value="{{ old('celular_alterno') }}"
                                   placeholder="9 dígitos, comienza con 9">
                            @error('celular_alterno')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="email_personal">Correo Personal</label>
                            <input type="email" name="email_personal" id="email_personal" 
                                   class="form-control @error('email_personal') is-invalid @enderror" 
                                   value="{{ old('email_personal') }}">
                            @error('email_personal')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <h4 class="mb-4">Roles</h4>
                        
                        <div class="form-group">
                            <label>Asignar Roles</label>
                            <div class="row">
                                @foreach($roles as $role)
                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" 
                                                   name="roles[]" value="{{ $role->id }}" 
                                                   id="role_{{ $role->id }}">
                                            <label class="form-check-label" for="role_{{ $role->id }}">
                                                {{ $role->name }}
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            @error('roles')
                                <span class="text-danger" style="font-size: 0.875em;">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="fecha_nacimiento">Fecha de Nacimiento</label>
                            <input type="date" name="fecha_nacimiento" id="fecha_nacimiento" 
                                   class="form-control @error('fecha_nacimiento') is-invalid @enderror" 
                                   value="{{ old('fecha_nacimiento') }}">
                            @error('fecha_nacimiento')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="direccion">Dirección</label>
                            <textarea name="direccion" id="direccion" 
                                      class="form-control @error('direccion') is-invalid @enderror" 
                                      rows="2">{{ old('direccion') }}</textarea>
                            @error('direccion')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('users.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Regresar
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Guardar Usuario
                    </button>
                </div>
            </form>
        </div>
    </div>
@stop

@section('js')
    <script>
        // Validación de DNI (8 dígitos)
        document.getElementById('dni').addEventListener('input', function(e) {
            this.value = this.value.replace(/[^0-9]/g, '').slice(0, 8);
        });

        // Validación de celular (9 dígitos que comienzan con 9)
        document.getElementById('celular').addEventListener('input', function(e) {
            this.value = this.value.replace(/[^0-9]/g, '').slice(0, 9);
            if (this.value.length > 0 && this.value[0] !== '9') {
                this.value = '9' + this.value.slice(1);
            }
        });

        // Validación de celular alterno (9 dígitos que comienzan con 9)
        document.getElementById('celular_alterno').addEventListener('input', function(e) {
            this.value = this.value.replace(/[^0-9]/g, '').slice(0, 9);
            if (this.value.length > 0 && this.value[0] !== '9') {
                this.value = '9' + this.value.slice(1);
            }
        });
    </script>
@stop