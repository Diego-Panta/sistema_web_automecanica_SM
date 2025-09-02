@extends('adminlte::page')

@section('title', 'Historial de Asignaciones')

@section('content_header')
    <h1>Historial de Asignaciones de Leads</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Filtros</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('leads.assign.history') }}">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="fecha_inicio">Fecha Inicio</label>
                            <input type="date" name="fecha_inicio" id="fecha_inicio" 
                                   class="form-control" value="{{ $filters['fecha_inicio'] ?? '' }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="fecha_fin">Fecha Fin</label>
                            <input type="date" name="fecha_fin" id="fecha_fin" 
                                   class="form-control" value="{{ $filters['fecha_fin'] ?? '' }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="tipo_lead_id">Tipo de Lead</label>
                            <select name="tipo_lead_id" id="tipo_lead_id" class="form-control">
                                <option value="">Todos los tipos</option>
                                @foreach($tiposLead as $tipo)
                                    <option value="{{ $tipo->id }}" 
                                        {{ ($filters['tipo_lead_id'] ?? '') == $tipo->id ? 'selected' : '' }}>
                                        {{ $tipo->nombre_tipo }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="usuario_asignado_id">Asesor</label>
                            <select name="usuario_asignado_id" id="usuario_asignado_id" class="form-control">
                                <option value="">Todos los asesores</option>
                                @foreach($asesores as $asesor)
                                    <option value="{{ $asesor->id }}" 
                                        {{ ($filters['usuario_asignado_id'] ?? '') == $asesor->id ? 'selected' : '' }}>
                                        {{ $asesor->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 text-right">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-filter"></i> Filtrar
                        </button>
                        <a href="{{ route('leads.assign.history') }}" class="btn btn-secondary">
                            <i class="fas fa-sync"></i> Limpiar
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>Lead</th>
                            <th>Tipo</th>
                            <th>Asesor Asignado</th>
                            <th>Asignado por</th>
                            <th>Fecha Asignación</th>
                            <th>Observación</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($assignments as $assignment)
                            <tr>
                                <td>
                                    #{{ $assignment->lead->id }} - 
                                    {{ $assignment->lead->cliente->nombre_completo }}
                                </td>
                                <td>
                                    <span class="badge badge-{{ $assignment->lead->tipo->badge_color ?? 'secondary' }}">
                                        {{ $assignment->lead->tipo->nombre_tipo }}
                                    </span>
                                </td>
                                <td>{{ $assignment->asignado->name }}</td>
                                <td>{{ $assignment->asignador->name }}</td>
                                <td>{{ $assignment->fecha_asignacion->format('d/m/Y H:i') }}</td>
                                <td>{{ $assignment->observacion ?? 'Sin observación' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center mt-3">
                {{ $assignments->appends($filters)->links() }}
            </div>
        </div>
    </div>
@stop