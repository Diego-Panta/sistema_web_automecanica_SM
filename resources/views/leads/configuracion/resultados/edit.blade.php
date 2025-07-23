@extends('adminlte::page')

@section('title', 'Editar Resultado de Lead')

@section('content_header')
    <h1>Editar Resultado</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('leads.results.update', $resultado) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="nombre_resultado">Nombre del Resultado*</label>
                    <input type="text" name="nombre_resultado" id="nombre_resultado" 
                           class="form-control @error('nombre_resultado') is-invalid @enderror" 
                           value="{{ old('nombre_resultado', $resultado->nombre_resultado) }}" 
                           placeholder="Ej: Contactado, No interesado, Vendido, etc." required>
                    @error('nombre_resultado')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                
                <div class="d-flex justify-content-between">
                    <a href="{{ route('leads.results') }}" class="btn btn-secondary">
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