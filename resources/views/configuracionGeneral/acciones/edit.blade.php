@extends('adminlte::page')

@section('title', 'Editar Acción')

@section('content_header')
    <h1>Editar Acción</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('accions.update', $accion) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="nombre_accion">Nombre de la Acción*</label>
                    <input type="text" name="nombre_accion" id="nombre_accion" 
                           class="form-control @error('nombre_accion') is-invalid @enderror" 
                           value="{{ old('nombre_accion', $accion->nombre_accion) }}" 
                           placeholder="Ej: Llamada, Email, Reunión, etc." required>
                    @error('nombre_accion')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="descripcion">Descripción (Opcional)</label>
                    <textarea name="descripcion" id="descripcion" 
                              class="form-control @error('descripcion') is-invalid @enderror" 
                              rows="3">{{ old('descripcion', $accion->descripcion) }}</textarea>
                    @error('descripcion')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                
                <div class="d-flex justify-content-between">
                    <a href="{{ route('accions.index') }}" class="btn btn-secondary">
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