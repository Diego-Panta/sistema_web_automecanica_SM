@extends('adminlte::page')

@section('title', 'Crear Sede')

@section('content_header')
    <h1>Crear Nueva Sede</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('locations.sedes.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="codigo_sede">Código de Sede*</label>
                            <input type="text" name="codigo_sede" id="codigo_sede" 
                                   class="form-control @error('codigo_sede') is-invalid @enderror" 
                                   value="{{ old('codigo_sede') }}" 
                                   placeholder="Ej: SEDE-001" required>
                            @error('codigo_sede')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nombre_sede">Nombre de la Sede*</label>
                            <input type="text" name="nombre_sede" id="nombre_sede" 
                                   class="form-control @error('nombre_sede') is-invalid @enderror" 
                                   value="{{ old('nombre_sede') }}" required>
                            @error('nombre_sede')
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
                            <label for="ciudad_id">Ciudad*</label>
                            <select name="ciudad_id" id="ciudad_id" 
                                    class="form-control @error('ciudad_id') is-invalid @enderror" required>
                                <option value="">Seleccione una ciudad</option>
                                @foreach($ciudades as $ciudad)
                                    <option value="{{ $ciudad->id }}" {{ old('ciudad_id') == $ciudad->id ? 'selected' : '' }}>
                                        {{ $ciudad->nombre }} @if($ciudad->region) - {{ $ciudad->region }} @endif
                                    </option>
                                @endforeach
                            </select>
                            @error('ciudad_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="capacidad">Capacidad (Opcional)</label>
                            <input type="number" name="capacidad" id="capacidad" 
                                   class="form-control @error('capacidad') is-invalid @enderror" 
                                   value="{{ old('capacidad') }}" min="1">
                            @error('capacidad')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="direccion">Dirección*</label>
                    <input type="text" name="direccion" id="direccion" 
                           class="form-control @error('direccion') is-invalid @enderror" 
                           value="{{ old('direccion') }}" required>
                    @error('direccion')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="descripcion">Descripción (Opcional)</label>
                    <textarea name="descripcion" id="descripcion" 
                              class="form-control @error('descripcion') is-invalid @enderror" 
                              rows="3">{{ old('descripcion') }}</textarea>
                    @error('descripcion')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                
                <div class="d-flex justify-content-between">
                    <a href="{{ route('locations.sedes') }}" class="btn btn-secondary">
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