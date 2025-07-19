@extends('adminlte::page')

@section('title', 'Editar Estado de Lead')

@section('content_header')
    <h1>Editar Estado de Lead</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('leads.status.update', $estado) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="nombre_estado">Nombre del Estado</label>
                    <input type="text" name="nombre_estado" id="nombre_estado" 
                           class="form-control @error('nombre_estado') is-invalid @enderror" 
                           value="{{ old('nombre_estado', $estado->nombre_estado) }}" 
                           placeholder="Ej: Nuevo, En contacto, Calificado, etc." required>
                    @error('nombre_estado')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                
                <div class="d-flex justify-content-between">
                    <a href="{{ route('leads.status') }}" class="btn btn-secondary">
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