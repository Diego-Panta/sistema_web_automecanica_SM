@extends('adminlte::page')

@section('title', 'Crear Tipo de Lead')

@section('content_header')
    <h1>Crear Nuevo Tipo de Lead</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('leads.types.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="nombre_tipo">Nombre del Tipo</label>
                    <input type="text" name="nombre_tipo" id="nombre_tipo" 
                           class="form-control @error('nombre_tipo') is-invalid @enderror" 
                           value="{{ old('nombre_tipo') }}" 
                           placeholder="Ej: Prospecto, Cliente Potencial, etc." required>
                    @error('nombre_tipo')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                
                <div class="d-flex justify-content-between">
                    <a href="{{ route('leads.types.index') }}" class="btn btn-secondary">
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