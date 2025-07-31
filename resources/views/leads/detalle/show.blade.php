@extends('adminlte::page')

@section('title', 'Detalle del Lead #' . $lead->id)

@section('content_header')
    <h1>Detalle del Lead #{{ $lead->id }}</h1>
    <div class="d-flex justify-content-between">
        <a href="{{ route('leads.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Volver al listado
        </a>
        <div>
            <a href="{{ route('leads.edit', $lead) }}" class="btn btn-primary">
                <i class="fas fa-edit"></i> Editar
            </a>
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Información Básica</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Cliente:</strong> 
                                <a href="{{ route('clientes.show', $lead->cliente_id) }}" target="_blank">
                                    {{ $lead->cliente->nombre_completo }}
                                </a>
                            </p>
                            <p><strong>Tipo:</strong> 
                                <span class="badge" style="background-color: {{ $lead->tipo->color ?? '#6c757d' }}; color: white;">
                                    {{ $lead->tipo->nombre_tipo }}
                                </span>
                            </p>
                            <p><strong>Estado:</strong> 
                                <span class="badge badge-{{ $lead->estadoActual->clase ?? 'secondary' }}">
                                    {{ $lead->estadoActual->nombre }}
                                </span>
                            </p>
                            <p><strong>Resultado:</strong> 
                                {{ $lead->resultado->nombre ?? 'N/A' }}
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Canal:</strong> {{ $lead->canal->nombre }}</p>
                            <p><strong>Medio Contacto:</strong> {{ $lead->medioContacto->nombre }}</p>
                            <p><strong>Forma Registro:</strong> {{ $lead->formaRegistro->nombre }}</p>
                            <p><strong>Modelo:</strong> {{ $lead->modeloVehiculo->nombre ?? 'N/A' }}</p>
                        </div>
                    </div>
                    
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <p><strong>Financiamiento:</strong> 
                                {{ $lead->financiamiento ? 'Sí' : 'No' }}
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Tiempo Compra:</strong> 
                                {{ $lead->tiempo_compra ?? 'No especificado' }}
                            </p>
                        </div>
                    </div>
                    
                    <div class="mt-3">
                        <p><strong>Observaciones:</strong></p>
                        <div class="border p-3 rounded">
                            {{ $lead->observacion ?? 'Sin observaciones' }}
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Historial de estados -->
            <div class="card mt-4">
                <div class="card-header">
                    <h3 class="card-title">Historial de Estados</h3>
                </div>
                <div class="card-body">
                    @if($lead->historialEstados->count() > 0)
                        <div class="timeline">
                            @foreach($lead->historialEstados as $historial)
                                <div class="time-label">
                                    <span class="bg-{{ $historial->estado->clase ?? 'info' }}">
                                        {{ $historial->created_at->format('d M. Y') }}
                                    </span>
                                </div>
                                <div>
                                    <i class="fas fa-tag bg-{{ $historial->estado->clase ?? 'info' }}"></i>
                                    <div class="timeline-item">
                                        <span class="time">
                                            <i class="fas fa-clock"></i> 
                                            {{ $historial->created_at->format('H:i') }}
                                        </span>
                                        <h3 class="timeline-header">
                                            {{ $historial->estado->nombre }}
                                        </h3>
                                        <div class="timeline-body">
                                            {{ $historial->observacion ?? 'Sin comentarios' }}
                                        </div>
                                        <div class="timeline-footer">
                                            <small>Cambiado por: {{ $historial->usuario->name }}</small>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            <div>
                                <i class="fas fa-clock bg-gray"></i>
                            </div>
                        </div>
                    @else
                        <p class="text-muted">No hay historial de estados registrado</p>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <!-- Información adicional -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Información Adicional</h3>
                </div>
                <div class="card-body">
                    <p><strong>Creado por:</strong> {{ $lead->creador->name ?? 'Sistema' }}</p>
                    <p><strong>Fecha creación:</strong> {{ $lead->created_at->format('d/m/Y H:i') }}</p>
                    <p><strong>Última actualización:</strong> {{ $lead->updated_at->format('d/m/Y H:i') }}</p>
                    @if($lead->fecha_cierre)
                        <p><strong>Fecha cierre:</strong> {{ $lead->fecha_cierre->format('d/m/Y H:i') }}</p>
                    @endif
                </div>
            </div>
            
            <!-- Asignaciones -->
            <div class="card mt-4">
                <div class="card-header">
                    <h3 class="card-title">Asignaciones</h3>
                </div>
                <div class="card-body">
                    @if($lead->asignaciones->count() > 0)
                        <ul class="list-group">
                            @foreach($lead->asignaciones as $asignacion)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>{{ $asignacion->usuarioAsignado->name }}</strong>
                                        <br>
                                        <small class="text-muted">
                                            Asignado por: {{ $asignacion->usuarioAsignador->name }}
                                            el {{ $asignacion->fecha_asignacion->format('d/m/Y') }}
                                        </small>
                                    </div>
                                    <span class="badge badge-secondary">
                                        {{ $asignacion->fecha_asignacion->diffForHumans() }}
                                    </span>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-muted">No hay asignaciones registradas</p>
                    @endif
                </div>
            </div>
            
            <!-- Acciones realizadas -->
            <div class="card mt-4">
                <div class="card-header">
                    <h3 class="card-title">Acciones Realizadas</h3>
                </div>
                <div class="card-body">
                    @if($lead->accionesRealizadas->count() > 0)
                        <ul class="list-unstyled">
                            @foreach($lead->accionesRealizadas as $accion)
                                <li class="mb-3">
                                    <div class="d-flex justify-content-between">
                                        <strong>{{ $accion->accion->nombre }}</strong>
                                        <small class="text-muted">
                                            {{ $accion->fecha->format('d/m/Y H:i') }}
                                        </small>
                                    </div>
                                    <div class="small text-muted">
                                        Realizada por: {{ $accion->usuario->name }}
                                    </div>
                                    @if($accion->comentario)
                                        <div class="border-left pl-2 mt-1">
                                            {{ $accion->comentario }}
                                        </div>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-muted">No hay acciones registradas</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <style>
        .badge {
            font-size: 0.9em;
            padding: 0.35em 0.65em;
        }
        .timeline {
            position: relative;
            padding: 0 0 0 1em;
            margin: 0 0 1em 0;
        }
        .timeline:before {
            content: '';
            position: absolute;
            top: 0;
            bottom: 0;
            width: 4px;
            background: #ddd;
            left: 2em;
            margin-left: -2px;
        }
        .timeline > .time-label > span {
            font-weight: 600;
            padding: 5px 10px;
            color: #fff;
            border-radius: 4px;
        }
        .timeline > div {
            margin-bottom: 15px;
            position: relative;
        }
        .timeline > div:before, 
        .timeline > div:after {
            content: "";
            display: table;
        }
        .timeline > div:after {
            clear: both;
        }
        .timeline > div > .timeline-item {
            box-shadow: 0 0 1px rgba(0,0,0,0.1);
            border-radius: 3px;
            margin-top: 0;
            background: #fff;
            color: #444;
            margin-left: 3em;
            padding: 0;
            position: relative;
        }
        .timeline > div > .timeline-item > .time {
            color: #999;
            float: right;
            padding: 10px;
            font-size: 12px;
        }
        .timeline > div > .timeline-item > .timeline-header {
            margin: 0;
            color: #555;
            border-bottom: 1px solid #f4f4f4;
            padding: 10px;
            font-size: 16px;
            line-height: 1.1;
        }
        .timeline > div > .timeline-item > .timeline-body, 
        .timeline > div > .timeline-item > .timeline-footer {
            padding: 10px;
        }
        .timeline > div > i {
            width: 2em;
            height: 2em;
            font-size: 1em;
            line-height: 2em;
            position: absolute;
            color: #fff;
            background: #6c757d;
            border-radius: 50%;
            text-align: center;
            left: 0;
            top: 0;
        }
    </style>
@stop