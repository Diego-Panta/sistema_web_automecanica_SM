@extends('adminlte::page')

@section('title', 'Crear Canal de Lead')

@section('content_header')
    <h1>Crear Nuevo Canal de Lead</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('leads.channels.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="nombre_canal">Nombre del Canal</label>
                    <input type="text" name="nombre_canal" id="nombre_canal" 
                           class="form-control @error('nombre_canal') is-invalid @enderror" 
                           value="{{ old('nombre_canal') }}" 
                           placeholder="Ej: Web, Redes Sociales, Referido, etc." required>
                    @error('nombre_canal')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                
                <div class="d-flex justify-content-between">
                    <a href="{{ route('leads.channels') }}" class="btn btn-secondary">
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