@extends('adminlte::page')

@section('title', 'Editar Cliente')

@section('content_header')
    <h1>Editar Cliente: {{ $cliente->nombre_completo }}</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('clientes.update', $cliente) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="nombre">Nombres *</label>
                            <input type="text" name="nombre" id="nombre" 
                                   class="form-control @error('nombre') is-invalid @enderror" 
                                   value="{{ old('nombre', $cliente->nombre) }}" required>
                            @error('nombre')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="apellido_paterno">Apellido Paterno *</label>
                            <input type="text" name="apellido_paterno" id="apellido_paterno" 
                                   class="form-control @error('apellido_paterno') is-invalid @enderror" 
                                   value="{{ old('apellido_paterno', $cliente->apellido_paterno) }}" required>
                            @error('apellido_paterno')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="apellido_materno">Apellido Materno</label>
                            <input type="text" name="apellido_materno" id="apellido_materno" 
                                   class="form-control @error('apellido_materno') is-invalid @enderror" 
                                   value="{{ old('apellido_materno', $cliente->apellido_materno) }}">
                            @error('apellido_materno')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="dni">DNI</label>
                            <input type="text" name="dni" id="dni" 
                                   class="form-control @error('dni') is-invalid @enderror" 
                                   value="{{ old('dni', $cliente->dni) }}" maxlength="8">
                            @error('dni')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="celular">Celular</label>
                            <input type="text" name="celular" id="celular" 
                                   class="form-control @error('celular') is-invalid @enderror" 
                                   value="{{ old('celular', $cliente->celular) }}" maxlength="9">
                            @error('celular')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="celular_alterno">Celular Alterno</label>
                            <input type="text" name="celular_alterno" id="celular_alterno" 
                                   class="form-control @error('celular_alterno') is-invalid @enderror" 
                                   value="{{ old('celular_alterno', $cliente->celular_alterno) }}" maxlength="9">
                            @error('celular_alterno')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="estado_cliente_id">Estado *</label>
                            <select name="estado_cliente_id" id="estado_cliente_id" 
                                    class="form-control @error('estado_cliente_id') is-invalid @enderror" required>
                                <option value="">Seleccione un estado</option>
                                @foreach($estados as $estado)
                                    <option value="{{ $estado->id }}" 
                                        {{ old('estado_cliente_id', $cliente->estado_cliente_id) == $estado->id ? 'selected' : '' }}>
                                        {{ $estado->nombre_estado }}
                                    </option>
                                @endforeach
                            </select>
                            @error('estado_cliente_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="correo">Correo Electrónico</label>
                    <input type="email" name="correo" id="correo" 
                           class="form-control @error('correo') is-invalid @enderror" 
                           value="{{ old('correo', $cliente->correo) }}">
                    @error('correo')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('clientes.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Cancelar
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Actualizar Cliente
                    </button>
                </div>
            </form>
        </div>
    </div>
@stop

@section('js')
    <script>
        $(document).ready(function() {
            // Validar DNI solo números
            $('#dni').on('input', function() {
                this.value = this.value.replace(/[^0-9]/g, '');
            });

            // Validar celulares solo números
            $('#celular, #celular_alterno').on('input', function() {
                this.value = this.value.replace(/[^0-9]/g, '');
            });
        });
    </script>
@stop