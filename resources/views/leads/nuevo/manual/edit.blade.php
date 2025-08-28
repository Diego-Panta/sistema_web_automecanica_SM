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
                
                <!-- Campo oculto para mantener la relación con el cliente -->
                <input type="hidden" name="cliente_id" value="{{ $lead->cliente_id }}">
                
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
                                    <label>Tipo de Documento</label>
                                    <input type="text" class="form-control" 
                                           value="{{ $lead->cliente->tipoDocumento->nombre ?? 'N/A' }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="form-group">
                                        <label>Número de Documento</label>
                                        <input type="text" class="form-control" 
                                               value="{{ $lead->cliente->numero_documento ?? 'N/A' }}" readonly>
                                    </div>
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

                <!-- Campos Específicos según el Tipo de Lead -->
                @include('leads.nuevo.manual._lead_form_dinamico_edit')

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
        
        /* Estilos para campos Select2 con errores */
        .select2-container.is-invalid .select2-selection--single {
            border-color: #dc3545;
            box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
        }
        
        /* Asegurar que los campos Select2 sean focusables */
        .select2-container .select2-selection--single {
            cursor: pointer;
        }
        
        .select2-container .select2-selection--single:focus {
            outline: none;
            border-color: #80bdff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }
        
        /* Estilos para campos requeridos */
        .field-required::after {
            content: " *";
            color: #dc3545;
        }
        
        /* Mejorar la apariencia de los mensajes de error */
        .invalid-feedback {
            display: block;
            width: 100%;
            margin-top: 0.25rem;
            font-size: 0.875em;
            color: #dc3545;
        }
        
        /* Estilos para campos con errores */
        .form-control.is-invalid,
        .select2-container.is-invalid .select2-selection--single {
            border-color: #dc3545;
            padding-right: calc(1.5em + 0.75rem);
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12' width='12' height='12' fill='none' stroke='%23dc3545'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath d='m5.8 4.6 1.4 1.4m0 0 1.4-1.4m-1.4 1.4L7.2 6m0 0L5.8 7.4'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right calc(0.375em + 0.1875rem) center;
            background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
        }
    </style>
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            // Inicializar select2 con configuración específica para evitar problemas de focus
            $('select').select2({
                placeholder: 'Seleccione una opción',
                allowClear: true,
                width: '100%'
            });

            // Mostrar campos específicos según el tipo de lead
            mostrarCamposEspecificos();

            // Manejar el cambio de tipo de lead
            $('#tipo_id').change(function() {
                mostrarCamposEspecificos();
                // Limpiar validaciones previas
                limpiarValidaciones();
            });

            // Función para mostrar campos específicos según el tipo de lead
            function mostrarCamposEspecificos() {
                // Ocultar todos los campos específicos
                $('.campos-especificos').hide();
                
                // Obtener el nombre del tipo seleccionado
                const tipoSeleccionado = $('#tipo_id option:selected').text().toLowerCase();
                
                if (tipoSeleccionado.includes('compra') || tipoSeleccionado.includes('cotización')) {
                    $('#camposCompra').show();
                    // Configurar campos requeridos para compra
                    configurarCamposRequeridos('compra');
                } else if (tipoSeleccionado.includes('postventa') || tipoSeleccionado.includes('servicio')) {
                    $('#camposPostventa').show();
                    // Configurar campos requeridos para postventa
                    configurarCamposRequeridos('postventa');
                } else if (tipoSeleccionado.includes('repuesto') || tipoSeleccionado.includes('cotiza')) {
                    $('#camposRepuesto').show();
                    // Configurar campos requeridos para repuesto
                    configurarCamposRequeridos('repuesto');
                } else {
                    // Limpiar todos los campos requeridos si no hay tipo seleccionado
                    limpiarCamposRequeridos();
                }
            }

            // Función para configurar campos requeridos según el tipo
            function configurarCamposRequeridos(tipo) {
                // Primero limpiar todos los campos requeridos
                limpiarCamposRequeridos();
                
                if (tipo === 'postventa') {
                    // Campos requeridos para postventa
                    $('#numero_placa_postventa').prop('required', true);
                    $('#kilometraje').prop('required', true);
                    $('#tipo_servicio_id').prop('required', true);
                    $('#fecha_cita').prop('required', true);
                    $('#horario_cita').prop('required', true);
                    
                    // Asegurar que los campos Select2 sean focusables
                    setTimeout(function() {
                        $('#tipo_servicio_id').next('.select2-container').find('.select2-selection').attr('tabindex', '0');
                        $('#horario_cita').next('.select2-container').find('.select2-selection').attr('tabindex', '0');
                    }, 100);
                } else if (tipo === 'compra') {
                    // Campos requeridos para compra
                    $('#tiempo_compra').prop('required', true);
                } else if (tipo === 'repuesto') {
                    // Campos requeridos para repuesto
                    $('#numero_placa_repuesto').prop('required', true);
                    $('#consulta_repuesto').prop('required', true);
                }
            }

            // Función para limpiar campos requeridos
            function limpiarCamposRequeridos() {
                $('.campos-especificos input, .campos-especificos select').prop('required', false);
            }

            // Función para limpiar validaciones
            function limpiarValidaciones() {
                $('.is-invalid').removeClass('is-invalid');
                $('.invalid-feedback').hide();
                $('.select2-container').removeClass('is-invalid');
            }

            // Validación del formulario antes de enviar
            $('form').on('submit', function(e) {
                let isValid = true;
                let errores = [];

                // Limpiar validaciones previas
                limpiarValidaciones();

                // Obtener el tipo de lead seleccionado
                const tipoSeleccionado = $('#tipo_id option:selected').text().toLowerCase();

                // Validar campos específicos según el tipo
                if (tipoSeleccionado.includes('postventa') || tipoSeleccionado.includes('servicio')) {
                    const camposPostventa = [
                        { campo: '#numero_placa_postventa', mensaje: 'El número de placa es obligatorio.' },
                        { campo: '#kilometraje', mensaje: 'El kilometraje es obligatorio.' },
                        { campo: '#tipo_servicio_id', mensaje: 'El tipo de servicio es obligatorio.' },
                        { campo: '#fecha_cita', mensaje: 'La fecha de cita es obligatoria.' },
                        { campo: '#horario_cita', mensaje: 'El horario de cita es obligatorio.' }
                    ];

                    camposPostventa.forEach(item => {
                        if (!$(item.campo).val()) {
                            $(item.campo).addClass('is-invalid');
                            // Para campos Select2, también marcar el contenedor
                            if ($(item.campo).hasClass('select2-hidden-accessible')) {
                                $(item.campo).next('.select2-container').addClass('is-invalid');
                            }
                            errores.push(item.mensaje);
                            isValid = false;
                        }
                    });
                } else if (tipoSeleccionado.includes('compra') || tipoSeleccionado.includes('cotización')) {
                    if (!$('#tiempo_compra').val()) {
                        $('#tiempo_compra').addClass('is-invalid');
                        errores.push('El tiempo de compra es obligatorio para leads de compra.');
                        isValid = false;
                    }
                } else if (tipoSeleccionado.includes('repuesto') || tipoSeleccionado.includes('cotiza')) {
                    if (!$('#numero_placa_repuesto').val()) {
                        $('#numero_placa_repuesto').addClass('is-invalid');
                        errores.push('El número de placa es obligatorio para leads de repuesto.');
                        isValid = false;
                    }
                    if (!$('#consulta_repuesto').val()) {
                        $('#consulta_repuesto').addClass('is-invalid');
                        errores.push('La consulta es obligatoria para leads de repuesto.');
                        isValid = false;
                    }
                }

                if (!isValid) {
                    e.preventDefault();
                    // Mostrar mensaje de error
                    if ($('.alert-danger').length === 0) {
                        $('form').prepend('<div class="alert alert-danger"><ul><li>' + errores.join('</li><li>') + '</li></ul></div>');
                    }
                    // Hacer scroll al primer error
                    $('html, body').animate({
                        scrollTop: $('.is-invalid:first').offset().top - 100
                    }, 500);
                }
            });

            // Hacer que los campos Select2 sean focusables cuando se muestren
            $(document).on('shown.bs.tab', function() {
                setTimeout(function() {
                    $('.select2-container').each(function() {
                        $(this).find('.select2-selection').attr('tabindex', '0');
                    });
                }, 100);
            });

            // Asegurar que los campos Select2 sean focusables después de la inicialización
            setTimeout(function() {
                $('.select2-container').each(function() {
                    $(this).find('.select2-selection').attr('tabindex', '0');
                });
            }, 200);

            // Configurar campos requeridos inicialmente
            setTimeout(function() {
                mostrarCamposEspecificos();
            }, 300);
        });
    </script>
@stop