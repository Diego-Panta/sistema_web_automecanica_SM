@extends('adminlte::page')

@section('title', 'Editar Modelo de Vehículo')

@section('content_header')
    <h1>Editar Modelo</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('vehicles.models.update', $modelo) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="marca_id">Marca*</label>
                            <select name="marca_id" id="marca_id" 
                                    class="form-control @error('marca_id') is-invalid @enderror" required>
                                <option value="">Seleccione una marca</option>
                                @foreach($marcas as $marca)
                                    <option value="{{ $marca->id }}" 
                                        {{ (old('marca_id', $modelo->marca_id) == $marca->id) ? 'selected' : '' }}>
                                        {{ $marca->nombre_marca }}
                                    </option>
                                @endforeach
                            </select>
                            @error('marca_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="tipo_id">Tipo de Vehículo*</label>
                            <select name="tipo_id" id="tipo_id" 
                                    class="form-control @error('tipo_id') is-invalid @enderror" required>
                                <option value="">Seleccione un tipo</option>
                                @foreach($tipos as $tipo)
                                    <option value="{{ $tipo->id }}" 
                                        {{ (old('tipo_id', $modelo->tipo_id) == $tipo->id) ? 'selected' : '' }}>
                                        {{ $tipo->nombre_tipo_vehiculo }}
                                    </option>
                                @endforeach
                            </select>
                            @error('tipo_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="nombre_modelo">Nombre del Modelo*</label>
                    <input type="text" name="nombre_modelo" id="nombre_modelo" 
                           class="form-control @error('nombre_modelo') is-invalid @enderror" 
                           value="{{ old('nombre_modelo', $modelo->nombre_modelo) }}" 
                           placeholder="Ej: Corolla, Civic, Mustang, etc." required>
                    @error('nombre_modelo')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                
                <div class="d-flex justify-content-between">
                    <a href="{{ route('vehicles.models') }}" class="btn btn-secondary">
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