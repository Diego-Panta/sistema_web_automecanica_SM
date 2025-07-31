@extends('adminlte::page')

@section('title', 'Editar Lead')

@section('content_header')
    <h1>Editar Lead #{{ $lead->id }}</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('leads.update', $lead) }}" method="POST">
                @csrf
                @method('PUT')
                
                <!-- Información del Cliente (solo lectura) -->
                <div class="card mb-4">
                    <div class="card-header bg-info text-white">
                        <h3 class="card-title">Información del Cliente</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Nombre Completo</label>
                                    <input type="text" class="form-control" 
                                           value="{{ $lead->cliente->nombre_completo }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>DNI</label>
                                    <input type="text" class="form-control" 
                                           value="{{ $lead->cliente->dni ?? 'N/A' }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Celular</label>
                                    <input type="text" class="form-control" 
                                           value="{{ $lead->cliente->celular ?? 'N/A' }}" readonly>
                                </div>
                            </div>
                        </div>
                        <a href="{{ route('clientes.edit', $lead->cliente) }}" class="btn btn-sm btn-warning">
                            <i class="fas fa-edit"></i> Editar Cliente
                        </a>
                    </div>
                </div>

                <!-- Sección de Datos del Lead -->
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <h3 class="card-title">Datos del Lead</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="tipo_id">Tipo de Lead *</label>
                                    <select name="tipo_id" id="tipo_id" 
                                            class="form-control @error('tipo_id') is-invalid @enderror" required>
                                        <option value="">Seleccione</option>
                                        @foreach($tipos as $tipo)
                                            <option value="{{ $tipo->id }}" 
                                                {{ $lead->tipo_id == $tipo->id ? 'selected' : '' }}>
                                                {{ $tipo->nombre_tipo }}
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
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="canal_id">Canal *</label>
                                    <select name="canal_id" id="canal_id" 
                                            class="form-control @error('canal_id') is-invalid @enderror" required>
                                        <option value="">Seleccione</option>
                                        @foreach($canales as $canal)
                                            <option value="{{ $canal->id }}" 
                                                {{ $lead->canal_id == $canal->id ? 'selected' : '' }}>
                                                {{ $canal->nombre_canal }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('canal_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="estado_actual_id">Estado Actual *</label>
                                    <select name="estado_actual_id" id="estado_actual_id" 
                                            class="form-control @error('estado_actual_id') is-invalid @enderror" required>
                                        <option value="">Seleccione</option>
                                        @foreach($estados as $estado)
                                            <option value="{{ $estado->id }}" 
                                                {{ $lead->estado_actual_id == $estado->id ? 'selected' : '' }}>
                                                {{ $estado->nombre_estado }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('estado_actual_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Resto de campos del lead (similar a create) -->
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="medio_contacto_id">Medio de Contacto *</label>
                                    <select name="medio_contacto_id" id="medio_contacto_id" 
                                            class="form-control @error('medio_contacto_id') is-invalid @enderror" required>
                                        <option value="">Seleccione</option>
                                        @foreach($mediosContacto as $medio)
                                            <option value="{{ $medio->id }}" 
                                                {{ $lead->medio_contacto_id == $medio->id ? 'selected' : '' }}>
                                                {{ $medio->nombre_medio }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('medio_contacto_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="forma_registro_id">Forma de Registro *</label>
                                    <select name="forma_registro_id" id="forma_registro_id" 
                                            class="form-control @error('forma_registro_id') is-invalid @enderror" required>
                                        <option value="">Seleccione</option>
                                        @foreach($formasRegistro as $forma)
                                            <option value="{{ $forma->id }}" 
                                                {{ $lead->forma_registro_id == $forma->id ? 'selected' : '' }}>
                                                {{ $forma->nombre_forma }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('forma_registro_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="modelo_id">Modelo de Vehículo</label>
                                    <select name="modelo_id" id="modelo_id" 
                                            class="form-control @error('modelo_id') is-invalid @enderror">
                                        <option value="">Seleccione</option>
                                        @foreach($modelos as $modelo)
                                            <option value="{{ $modelo->id }}" 
                                                {{ $lead->modelo_id == $modelo->id ? 'selected' : '' }}>
                                                {{ $modelo->nombre_modelo }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('modelo_id')
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
                                    <label for="tiempo_compra">Tiempo de Compra</label>
                                    <input type="text" name="tiempo_compra" id="tiempo_compra" 
                                           class="form-control @error('tiempo_compra') is-invalid @enderror" 
                                           value="{{ old('tiempo_compra', $lead->tiempo_compra) }}" 
                                           placeholder="Ej: 1-3 meses, 3-6 meses, etc.">
                                    @error('tiempo_compra')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="form-check mt-4 pt-2">
                                        <input type="checkbox" name="financiamiento" id="financiamiento" 
                                               class="form-check-input" value="1" 
                                               {{ old('financiamiento', $lead->financiamiento) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="financiamiento">Requiere financiamiento</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="observacion">Observación</label>
                            <textarea name="observacion" id="observacion" 
                                      class="form-control @error('observacion') is-invalid @enderror" 
                                      rows="3">{{ old('observacion', $lead->observacion) }}</textarea>
                            @error('observacion')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        @if($lead->fecha_cierre)
                        <div class="form-group">
                            <label for="fecha_cierre">Fecha de Cierre</label>
                            <input type="datetime-local" name="fecha_cierre" id="fecha_cierre" 
                                   class="form-control @error('fecha_cierre') is-invalid @enderror" 
                                   value="{{ old('fecha_cierre', $lead->fecha_cierre->format('Y-m-d\TH:i')) }}">
                            @error('fecha_cierre')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        @endif
                    </div>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('leads.show', $lead) }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Cancelar
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Actualizar Lead
                    </button>
                </div>
            </form>
        </div>
    </div>
@stop

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .card-header {
            font-weight: bold;
        }
        .form-group {
            margin-bottom: 1.2rem;
        }
        .select2-container--default .select2-selection--single {
            height: calc(2.25rem + 2px);
            padding: .375rem .75rem;
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: calc(2.25rem + 2px);
        }
    </style>
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            // Inicializar select2
            $('select').select2({
                placeholder: 'Seleccione una opción',
                allowClear: true
            });
        });
    </script>
@stop