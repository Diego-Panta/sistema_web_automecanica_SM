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
                        <div class="form-group radio-group">
                            <label class="d-block mb-2"><strong>Tipo de Cliente:</strong></label>
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
                            <div class="alert alert-info mt-2 mb-0">
                                <i class="fas fa-info-circle"></i>
                                <strong>Información:</strong> Seleccione "Cliente Existente" si el cliente ya está
                                registrado en el sistema,
                                o "Nuevo Cliente" si necesita crear un nuevo registro de cliente.
                            </div>
                        </div>

                        <!-- Selector de Cliente Existente -->
                        <div id="clienteExistenteSection" class="form-section">
                            <div class="section-header">
                                <h5><i class="fas fa-user-check"></i> Seleccionar Cliente Existente</h5>
                            </div>
                            <div class="form-group">
                                <label for="cliente_id" class="field-required">Cliente</label>
                                <select name="cliente_id" id="cliente_id"
                                    class="form-control select2 @error('cliente_id') is-invalid @enderror">
                                    <option value="">Buscar cliente...</option>
                                    @foreach ($clientes as $cliente)
                                        <option value="{{ $cliente->id }}"
                                            {{ old('cliente_id') == $cliente->id ? 'selected' : '' }}>
                                            {{ $cliente->nombre_completo }} -
                                            {{ $cliente->tipoDocumento->nombre ?? 'Sin documento' }}:
                                            {{ $cliente->numero_documento ?? 'N/A' }} -
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
                        <div id="nuevoClienteSection" class="form-section" style="display: none;">
                            <div class="section-header">
                                <h5><i class="fas fa-user-plus"></i> Datos del Nuevo Cliente</h5>
                            </div>
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

                <!-- Campos Específicos según el Tipo de Lead -->
                @include('leads.nuevo.manual._lead_form_dinamico')

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

        .radio-group {
            margin-bottom: 1.5rem;
        }

        .radio-group .custom-control {
            margin-right: 2rem;
        }

        .section-header {
            background: #f8f9fa;
            padding: 0.75rem 1rem;
            border-radius: 0.25rem;
            margin-bottom: 1rem;
            border-left: 4px solid #007bff;
        }

        .section-header h5 {
            margin: 0;
            color: #495057;
            font-weight: 600;
        }

        .field-required::after {
            content: " *";
            color: #dc3545;
            font-weight: bold;
        }

        .form-section {
            border: 1px solid #dee2e6;
            border-radius: 0.375rem;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            background: #fff;
        }

        .form-section.hidden {
            display: none;
        }

        .alert {
            border-radius: 0.375rem;
        }

        .invalid-feedback {
            display: block;
        }
    </style>
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        var modelosPorMarcaUrl = "{{ route('leads.modelos.por.marca', ['marcaId' => ':marcaId']) }}";
    </script>
    <script>
        $(document).ready(function() {
            // Inicializar select2
            $('#cliente_id').select2({
                placeholder: 'Buscar cliente...',
                allowClear: true
            });

            // Función para limpiar campos del formulario de nuevo cliente
            function limpiarCamposNuevoCliente() {
                $('#nuevoClienteSection input[type="text"], #nuevoClienteSection input[type="email"]').val('');
                $('#nuevoClienteSection select').prop('selectedIndex', 0);
                $('#nuevoClienteSection .is-invalid').removeClass('is-invalid');
                $('#nuevoClienteSection .invalid-feedback').hide();
            }

            // Función para limpiar selector de cliente existente
            function limpiarClienteExistente() {
                $('#cliente_id').val('').trigger('change');
                $('#cliente_id').removeClass('is-invalid');
                $('#cliente_id').siblings('.invalid-feedback').hide();
            }

            // Función para configurar campos requeridos dinámicamente
            function configurarCamposEspecificosPorTipo(tipoSeleccionado) {
                // Limpiar todos los required de campos específicos
                $('.campos-especificos input, .campos-especificos select, .campos-especificos textarea').prop(
                    'required', false);

                if (tipoSeleccionado.includes('compra') || tipoSeleccionado.includes('cotización')) {
                    $('#tiempo_compra', '#medio_contacto_id').prop('required', true);
                } else if (tipoSeleccionado.includes('postventa') || tipoSeleccionado.includes('servicio')) {
                    $('#numero_placa_postventa, #kilometraje, #tipo_servicio_id, #fecha_cita, #horario_cita').prop(
                        'required', true);
                } else if (tipoSeleccionado.includes('repuesto') || tipoSeleccionado.includes('cotiza')) {
                    $('#numero_placa_repuesto').prop('required', true);
                }
            }

            // Función para configurar campos requeridos
            function configurarCamposRequeridos(tipoCliente) {
                if (tipoCliente === 'existente') {
                    // Hacer requerido solo el selector de cliente existente
                    $('#cliente_id').prop('required', true);

                    // Remover required de todos los campos de nuevo cliente
                    $('#nuevoClienteSection input, #nuevoClienteSection select').prop('required', false);

                } else {
                    // Hacer no requerido el selector de cliente existente
                    $('#cliente_id').prop('required', false);

                    // Hacer requeridos solo los campos obligatorios de nuevo cliente
                    $('#nombre, #apellido_paterno, #tipo_documento_id, #estado_cliente_id').prop('required', true);

                    // Los demás campos no son requeridos
                    $('#apellido_materno, #numero_documento, #celular, #celular_alterno, #correo').prop('required',
                        false);
                }
            }

            // Manejar el cambio entre cliente existente y nuevo
            $('input[name="tipo_cliente"]').change(function() {
                const tipoCliente = $(this).val();

                if (tipoCliente === 'existente') {
                    $('#clienteExistenteSection').show();
                    $('#nuevoClienteSection').hide();
                    limpiarCamposNuevoCliente();
                    $('#nuevoClienteSection .is-invalid').removeClass('is-invalid');
                    $('#nuevoClienteSection .invalid-feedback').hide();
                } else {
                    $('#clienteExistenteSection').hide();
                    $('#nuevoClienteSection').show();
                    limpiarClienteExistente();
                    $('#cliente_id').removeClass('is-invalid');
                    $('#cliente_id').siblings('.invalid-feedback').hide();
                }

                configurarCamposRequeridos(tipoCliente);
            });

            // Manejar el cambio de tipo de lead
            $('#tipo_id').change(function() {
                const tipoSeleccionado = $(this).find('option:selected').text().toLowerCase();
                mostrarCamposEspecificos(tipoSeleccionado);
                configurarCamposEspecificosPorTipo(tipoSeleccionado);
            });

            // Función para mostrar campos específicos según el tipo de lead
            function mostrarCamposEspecificos(tipoSeleccionado) {
                // Ocultar todos los campos específicos
                $('.campos-especificos').hide();

                if (tipoSeleccionado.includes('compra') || tipoSeleccionado.includes('cotización')) {
                    $('#camposCompra').show();
                } else if (tipoSeleccionado.includes('postventa') || tipoSeleccionado.includes('servicio')) {
                    $('#camposPostventa').show();
                } else if (tipoSeleccionado.includes('repuesto') || tipoSeleccionado.includes('cotiza')) {
                    $('#camposRepuesto').show();
                }
            }

            // Validación de campos numéricos
            $('#numero_documento, #celular, #celular_alterno, #kilometraje').on('input', function() {
                this.value = this.value.replace(/[^0-9]/g, '');
            });

            // Validación en tiempo real para número de documento
            $('#numero_documento').on('blur', function() {
                if ($(this).val().length > 0 && $(this).val().length > 20) {
                    $(this).addClass('is-invalid');
                    if (!$(this).siblings('.invalid-feedback').length) {
                        $(this).after(
                            '<span class="invalid-feedback"><strong>El número de documento no puede exceder los 20 caracteres.</strong></span>'
                        );
                    }
                } else {
                    $(this).removeClass('is-invalid');
                    $(this).siblings('.invalid-feedback').remove();
                }
            });

            // Validación en tiempo real para celular
            $('#celular, #celular_alterno').on('blur', function() {
                if ($(this).val().length > 0 && $(this).val().length !== 9) {
                    $(this).addClass('is-invalid');
                    if (!$(this).siblings('.invalid-feedback').length) {
                        $(this).after(
                            '<span class="invalid-feedback"><strong>El celular debe tener 9 dígitos.</strong></span>'
                        );
                    }
                } else {
                    $(this).removeClass('is-invalid');
                    $(this).siblings('.invalid-feedback').remove();
                }
            });

            // Validación para número de placa (formato ABC-123)
            $('#numero_placa_postventa, #numero_placa_repuesto').on('input', function() {
                let valor = $(this).val().toUpperCase();
                // Permitir solo letras, números y guión
                valor = valor.replace(/[^A-Z0-9-]/g, '');
                $(this).val(valor);
            });

            // Configurar campos requeridos inicialmente (cliente existente por defecto)
            configurarCamposRequeridos('existente');

            // Mostrar campos específicos según el tipo de lead seleccionado inicialmente
            if ($('#tipo_id').val()) {
                const tipoSeleccionado = $('#tipo_id option:selected').text().toLowerCase();
                mostrarCamposEspecificos(tipoSeleccionado);
                configurarCamposEspecificosPorTipo(tipoSeleccionado);
            }

            // Si hay errores en el formulario de nuevo cliente, mostrar esa sección
            @if (
                $errors->has('nombre') ||
                    $errors->has('apellido_paterno') ||
                    $errors->has('tipo_documento_id') ||
                    $errors->has('numero_documento') ||
                    $errors->has('estado_cliente_id'))
                $('#nuevo_cliente').prop('checked', true).trigger('change');
            @endif

            // Si hay errores en el selector de cliente existente, mostrar esa sección
            @if ($errors->has('cliente_id'))
                $('#cliente_existente').prop('checked', true).trigger('change');
            @endif

            // Validación del formulario antes de enviar
            $('#leadForm').on('submit', function(e) {
                let isValid = true;
                let errores = [];

                // Obtener el tipo de cliente seleccionado
                const tipoCliente = $('input[name="tipo_cliente"]:checked').val();

                // Limpiar todos los errores previos
                $('.is-invalid').removeClass('is-invalid');
                $('.invalid-feedback').hide();
                $('.alert-danger').remove();

                // Validar cliente
                if (tipoCliente === 'existente') {
                    if (!$('#cliente_id').val()) {
                        $('#cliente_id').addClass('is-invalid');
                        errores.push('Debe seleccionar un cliente existente.');
                        isValid = false;
                    }
                } else if (tipoCliente === 'nuevo') {
                    const camposRequeridos = [{
                            campo: '#nombre',
                            mensaje: 'El nombre es obligatorio.'
                        },
                        {
                            campo: '#apellido_paterno',
                            mensaje: 'El apellido paterno es obligatorio.'
                        },
                        {
                            campo: '#tipo_documento_id',
                            mensaje: 'El tipo de documento es obligatorio.'
                        },
                        {
                            campo: '#estado_cliente_id',
                            mensaje: 'El estado del cliente es obligatorio.'
                        }
                    ];

                    camposRequeridos.forEach(item => {
                        if (!$(item.campo).val()) {
                            $(item.campo).addClass('is-invalid');
                            errores.push(item.mensaje);
                            isValid = false;
                        }
                    });
                }

                // Validar campos específicos según el tipo de lead
                const tipoSeleccionado = $('#tipo_id option:selected').text().toLowerCase();

                if (tipoSeleccionado.includes('compra') || tipoSeleccionado.includes('cotización')) {
                    if (!$('#tiempo_compra').val()) {
                        $('#tiempo_compra').addClass('is-invalid');
                        errores.push('El tiempo de compra es obligatorio para leads de compra.');
                        isValid = false;
                    }
                } else if (tipoSeleccionado.includes('postventa') || tipoSeleccionado.includes(
                        'servicio')) {
                    const camposPostventa = [{
                            campo: '#numero_placa_postventa',
                            mensaje: 'El número de placa es obligatorio.'
                        },
                        {
                            campo: '#kilometraje',
                            mensaje: 'El kilometraje es obligatorio.'
                        },
                        {
                            campo: '#tipo_servicio_id',
                            mensaje: 'El tipo de servicio es obligatorio.'
                        },
                        {
                            campo: '#fecha_cita',
                            mensaje: 'La fecha de cita es obligatoria.'
                        },
                        {
                            campo: '#horario_cita',
                            mensaje: 'El horario de cita es obligatorio.'
                        }
                    ];

                    camposPostventa.forEach(item => {
                        if (!$(item.campo).val()) {
                            $(item.campo).addClass('is-invalid');
                            errores.push(item.mensaje);
                            isValid = false;
                        }
                    });
                } else if (tipoSeleccionado.includes('repuesto') || tipoSeleccionado.includes('cotiza')) {
                    const camposRepuesto = [{
                        campo: '#numero_placa_repuesto',
                        mensaje: 'El número de placa es obligatorio.'
                    }];

                    camposRepuesto.forEach(item => {
                        if (!$(item.campo).val()) {
                            $(item.campo).addClass('is-invalid');
                            errores.push(item.mensaje);
                            isValid = false;
                        }
                    });
                }

                if (!isValid) {
                    e.preventDefault();
                    // Mostrar mensaje de error con todos los errores
                    let mensajeError = '<div class="alert alert-danger mt-3"><ul class="mb-0">';
                    errores.forEach(error => {
                        mensajeError += `<li>${error}</li>`;
                    });
                    mensajeError += '</ul></div>';

                    $(mensajeError).insertBefore('#leadForm .d-flex');

                    // Scroll al primer error
                    $('html, body').animate({
                        scrollTop: $('.is-invalid').first().offset().top - 100
                    }, 500);
                }
            });
        });
    </script>
    <script>
        $('#marca_id').change(function() {
            const marcaId = $(this).val();
            const modeloSelect = $('#modelo_id');

            if (marcaId) {
                // Habilitar el select de modelos
                modeloSelect.prop('disabled', false);

                // Cargar modelos por marca via AJAX
                $.ajax({
                    url: modelosPorMarcaUrl.replace(':marcaId', marcaId),
                    type: 'GET',
                    success: function(data) {
                        modeloSelect.empty().append('<option value="">Seleccione el modelo</option>');

                        $.each(data, function(key, modelo) {
                            modeloSelect.append(
                                `<option value="${modelo.id}">${modelo.nombre_modelo}</option>`
                            );
                        });

                        // Seleccionar valor antiguo si existe
                        @if (old('modelo_id'))
                            modeloSelect.val('{{ old('modelo_id') }}');
                        @endif
                    },
                    error: function() {
                        console.error('Error al cargar modelos');
                    }
                });
            } else {
                // Deshabilitar y limpiar si no hay marca seleccionada
                modeloSelect.prop('disabled', true).empty().append(
                    '<option value="">Primero seleccione una marca</option>');
            }
        });

        // Trigger change al cargar la página si ya hay una marca seleccionada
        @if (old('marca_id'))
            $('#marca_id').trigger('change');
        @endif
    </script>
@stop
