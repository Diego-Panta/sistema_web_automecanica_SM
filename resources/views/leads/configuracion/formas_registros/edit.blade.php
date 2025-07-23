@extends('adminlte::page')

@section('title', 'Editar Forma de Registro')

@section('content_header')
    <h1>Editar Forma de Registro</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('leads.registrations.update', $forma) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="nombre_forma">Nombre de la Forma*</label>
                    <input type="text" name="nombre_forma" id="nombre_forma" 
                           class="form-control @error('nombre_forma') is-invalid @enderror" 
                           value="{{ old('nombre_forma', $forma->nombre_forma) }}" 
                           placeholder="Ej: Formulario web, Llamada telefónica, etc." required>
                    @error('nombre_forma')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                
                <div class="d-flex justify-content-between">
                    <a href="{{ route('leads.registrations') }}" class="btn btn-secondary">
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