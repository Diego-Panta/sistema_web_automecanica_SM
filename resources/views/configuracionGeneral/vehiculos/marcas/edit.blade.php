@extends('adminlte::page')

@section('title', 'Editar Marca de Vehículo')

@section('content_header')
    <h1>Editar Marca</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('vehicles.brands.update', $marca) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="nombre_marca">Nombre de la Marca*</label>
                    <input type="text" name="nombre_marca" id="nombre_marca" 
                           class="form-control @error('nombre_marca') is-invalid @enderror" 
                           value="{{ old('nombre_marca', $marca->nombre_marca) }}" 
                           placeholder="Ej: Toyota, Ford, Honda, etc." required>
                    @error('nombre_marca')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                
                <div class="d-flex justify-content-between">
                    <a href="{{ route('vehicles.brands') }}" class="btn btn-secondary">
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