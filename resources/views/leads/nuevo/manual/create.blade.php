@extends('adminlte::page')

@section('title', 'Registro Manual de Lead')

@section('content_header')
    <h1>Registro Manual de Lead</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('leads.store.manual') }}" method="POST" id="leadForm">
                @csrf

                <!-- Widget de Selección de Cliente -->
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <h3 class="card-title">Selección de Cliente</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="cliente_existente" name="tipo_cliente"
                                    class="custom-control-input" value="existente" checked>
                                <label class="custom-control-label" for="cliente_existente">Cliente Existente</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="nuevo_cliente" name="tipo_cliente" class="custom-control-input"
                                    value="nuevo">
                                <label class="custom-control-label" for="nuevo_cliente">Nuevo Cliente</label>
                            </div>
                        </div>

                        <!-- Selector de Cliente Existente -->
                        <div id="clienteExistenteSection">
                            <div class="form-group">
                                <label for="cliente_id">Seleccionar Cliente *</label>
                                <select name="cliente_id" id="cliente_id"
                                    class="form-control select2 @error('cliente_id') is-invalid @enderror">
                                    <option value="">Buscar cliente...</option>
                                    @foreach ($clientes as $cliente)
                                        <option value="{{ $cliente->id }}"
                                            {{ old('cliente_id') == $cliente->id ? 'selected' : '' }}>
                                            {{ $cliente->nombre_completo }} -
                                            {{ $cliente->dni ?? 'Sin DNI' }} -
                                            {{ $cliente->celular ?? 'Sin celular' }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('cliente_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <!-- Formulario de Nuevo Cliente (oculto inicialmente) -->
                        <div id="nuevoClienteSection" style="display: none;">
                            @include('leads.nuevo.manual._cliente_form')
                        </div>
                    </div>
                </div>

                <!-- Sección de Datos del Lead -->
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <h3 class="card-title">Datos del Lead</h3>
                    </div>
                    <div class="card-body">
                        @include('leads.nuevo.manual._lead_form')
                    </div>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('leads.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Cancelar
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Guardar Lead
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

        #nuevoClienteSection {
            transition: all 0.3s ease;
        }
    </style>
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            // Inicializar select2
            $('#cliente_id').select2({
                placeholder: 'Buscar cliente...',
                allowClear: true
            });

            // Manejar el cambio entre cliente existente y nuevo
            $('input[name="tipo_cliente"]').change(function() {
                if ($(this).val() === 'existente') {
                    $('#clienteExistenteSection').show();
                    $('#nuevoClienteSection').hide();
                    $('#cliente_id').prop('required', true);
                    // Hacer no requeridos los campos de nuevo cliente
                    $('#nuevoClienteSection input, #nuevoClienteSection select').prop('required', false);
                } else {
                    $('#clienteExistenteSection').hide();
                    $('#nuevoClienteSection').show();
                    $('#cliente_id').prop('required', false);
                    // Hacer requeridos los campos de nuevo cliente
                    $('#nuevoClienteSection input[required], #nuevoClienteSection select[required]').prop(
                        'required', true);
                }
            });

            // Validación de campos numéricos
            $('#dni, #celular, #celular_alterno').on('input', function() {
                this.value = this.value.replace(/[^0-9]/g, '');
            });

            // Si hay errores en el formulario de nuevo cliente, mostrar esa sección
            @if ($errors->has('nombre') || $errors->has('apellido_paterno') || $errors->has('dni'))
                $('#nuevo_cliente').prop('checked', true).trigger('change');
            @endif
        });
    </script>
@stop
