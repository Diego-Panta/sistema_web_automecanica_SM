@extends('adminlte::page')

@section('title', 'Editar Sede')

@section('content_header')
    <h1>Editar Sede</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('locations.sedes.update', $sede) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="codigo_sede">Código de Sede*</label>
                            <input type="text" name="codigo_sede" id="codigo_sede" 
                                   class="form-control @error('codigo_sede') is-invalid @enderror" 
                                   value="{{ old('codigo_sede', $sede->codigo_sede) }}" 
                                   placeholder="Ej: SEDE-001" required>
                            @error('codigo_sede')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nombre_sede">Nombre de la Sede*</label>
                            <input type="text" name="nombre_sede" id="nombre_sede" 
                                   class="form-control @error('nombre_sede') is-invalid @enderror" 
                                   value="{{ old('nombre_sede', $sede->nombre_sede) }}" required>
                            @error('nombre_sede')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="ciudad">Ciudad*</label>
                            <input type="text" name="ciudad" id="ciudad" 
                                   class="form-control @error('ciudad') is-invalid @enderror" 
                                   value="{{ old('ciudad', $sede->ciudad) }}" required>
                            @error('ciudad')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="capacidad">Capacidad (Opcional)</label>
                            <input type="number" name="capacidad" id="capacidad" 
                                   class="form-control @error('capacidad') is-invalid @enderror" 
                                   value="{{ old('capacidad', $sede->capacidad) }}" min="1">
                            @error('capacidad')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="direccion">Dirección*</label>
                    <input type="text" name="direccion" id="direccion" 
                           class="form-control @error('direccion') is-invalid @enderror" 
                           value="{{ old('direccion', $sede->direccion) }}" required>
                    @error('direccion')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="descripcion">Descripción (Opcional)</label>
                    <textarea name="descripcion" id="descripcion" 
                              class="form-control @error('descripcion') is-invalid @enderror" 
                              rows="3">{{ old('descripcion', $sede->descripcion) }}</textarea>
                    @error('descripcion')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                
                <div class="d-flex justify-content-between">
                    <a href="{{ route('locations.sedes') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Regresar
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Actualizar
                    </button>
                </div>
            </form>
        </div>
    </div>
@stop