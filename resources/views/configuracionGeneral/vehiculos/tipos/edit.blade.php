@extends('adminlte::page')

@section('title', 'Editar Tipo de Vehículo')

@section('content_header')
    <h1>Editar Tipo de Vehículo</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('vehicles.types.update', $tipo) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="nombre_tipo_vehiculo">Nombre del Tipo*</label>
                    <input type="text" name="nombre_tipo_vehiculo" id="nombre_tipo_vehiculo" 
                           class="form-control @error('nombre_tipo_vehiculo') is-invalid @enderror" 
                           value="{{ old('nombre_tipo_vehiculo', $tipo->nombre_tipo_vehiculo) }}" 
                           placeholder="Ej: Automóvil, Camioneta, Motocicleta, etc." required>
                    @error('nombre_tipo_vehiculo')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                
                <div class="d-flex justify-content-between">
                    <a href="{{ route('vehicles.types') }}" class="btn btn-secondary">
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