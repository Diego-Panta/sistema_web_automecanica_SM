@extends('adminlte::page')

@section('title', 'Crear Sede')

@section('content_header')
    <h1>Crear Nueva Sede</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('locations.sedes.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="nombre_sede">Nombre de la Sede</label>
                    <input type="text" name="nombre_sede" id="nombre_sede" 
                           class="form-control @error('nombre_sede') is-invalid @enderror" 
                           value="{{ old('nombre_sede') }}" 
                           placeholder="Ej: Sede Principal, Sede Norte, etc." required>
                    @error('nombre_sede')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="direccion">Dirección</label>
                    <input type="text" name="direccion" id="direccion" 
                           class="form-control @error('direccion') is-invalid @enderror" 
                           value="{{ old('direccion') }}" required>
                    @error('direccion')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="capacidad">Capacidad (Opcional)</label>
                    <input type="number" name="capacidad" id="capacidad" 
                           class="form-control @error('capacidad') is-invalid @enderror" 
                           value="{{ old('capacidad') }}" min="1">
                    @error('capacidad')
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
                        <i class="fas fa-save"></i> Guardar
                    </button>
                </div>
            </form>
        </div>
    </div>
@stop