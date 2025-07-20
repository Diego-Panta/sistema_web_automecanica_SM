@extends('adminlte::page')

@section('title', 'Editar Turno')

@section('content_header')
    <h1>Editar Turno</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('locations.turnos.update', $turno) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nombre_turno">Nombre del Turno*</label>
                            <input type="text" name="nombre_turno" id="nombre_turno" 
                                   class="form-control @error('nombre_turno') is-invalid @enderror" 
                                   value="{{ old('nombre_turno', $turno->nombre_turno) }}" 
                                   placeholder="Ej: Mañana, Tarde, Noche, etc." required>
                            @error('nombre_turno')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="hora_inicio">Hora de Inicio*</label>
                            <input type="time" name="hora_inicio" id="hora_inicio" 
                                   class="form-control @error('hora_inicio') is-invalid @enderror" 
                                   value="{{ old('hora_inicio', $turno->hora_inicio) }}" required>
                            @error('hora_inicio')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="hora_fin">Hora de Fin*</label>
                            <input type="time" name="hora_fin" id="hora_fin" 
                                   class="form-control @error('hora_fin') is-invalid @enderror" 
                                   value="{{ old('hora_fin', $turno->hora_fin) }}" required>
                            @error('hora_fin')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <div class="d-flex justify-content-between">
                    <a href="{{ route('locations.turnos') }}" class="btn btn-secondary">
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