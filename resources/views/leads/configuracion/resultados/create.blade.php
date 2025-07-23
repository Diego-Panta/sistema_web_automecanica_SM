@extends('adminlte::page')

@section('title', 'Crear Resultado de Lead')

@section('content_header')
    <h1>Crear Nuevo Resultado</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('leads.results.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="nombre_resultado">Nombre del Resultado*</label>
                    <input type="text" name="nombre_resultado" id="nombre_resultado" 
                           class="form-control @error('nombre_resultado') is-invalid @enderror" 
                           value="{{ old('nombre_resultado') }}" 
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
                        <i class="fas fa-save"></i> Guardar
                    </button>
                </div>
            </form>
        </div>
    </div>
@stop