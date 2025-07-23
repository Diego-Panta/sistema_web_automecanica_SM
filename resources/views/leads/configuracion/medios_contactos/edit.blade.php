@extends('adminlte::page')

@section('title', 'Editar Medio de Contacto')

@section('content_header')
    <h1>Editar Medio de Contacto</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('leads.contacts.update', $medio) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="nombre_medio">Nombre del Medio*</label>
                    <input type="text" name="nombre_medio" id="nombre_medio" 
                           class="form-control @error('nombre_medio') is-invalid @enderror" 
                           value="{{ old('nombre_medio', $medio->nombre_medio) }}" 
                           placeholder="Ej: Teléfono, Email, Redes Sociales, etc." required>
                    @error('nombre_medio')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="descripcion">Descripción (Opcional)</label>
                    <textarea name="descripcion" id="descripcion" 
                              class="form-control @error('descripcion') is-invalid @enderror" 
                              rows="3">{{ old('descripcion', $medio->descripcion) }}</textarea>
                    @error('descripcion')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                
                <div class="d-flex justify-content-between">
                    <a href="{{ route('leads.contacts') }}" class="btn btn-secondary">
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