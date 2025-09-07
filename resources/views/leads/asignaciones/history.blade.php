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
                            <input type="date" name="fecha_inicio" id="fecha_inicio" class="form-control"
                                value="{{ $filters['fecha_inicio'] ?? '' }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="fecha_fin">Fecha Fin</label>
                            <input type="date" name="fecha_fin" id="fecha_fin" class="form-control"
                                value="{{ $filters['fecha_fin'] ?? '' }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="tipo_lead_id">Tipo de Lead</label>
                            <select name="tipo_lead_id" id="tipo_lead_id" class="form-control">
                                <option value="">Todos los tipos</option>
                                @foreach ($tiposLead as $tipo)
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
                                @foreach ($asesores as $asesor)
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
                            <th>Estado</th>
                            <th>Observación</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($assignments as $assignment)
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
                                <td>
                                    @if ($assignment->activo)
                                        <span class="badge badge-success">Activo</span>
                                    @else
                                        <span class="badge badge-danger">Cancelado</span>
                                    @endif
                                </td>
                                <td>{{ $assignment->observacion ?? 'Sin observación' }}</td>
                                <td>
                                    @if ($assignment->activo)
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('leads.assign.edit', $assignment->lead) }}"
                                                class="btn btn-sm btn-warning" title="Editar asignación">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button" class="btn btn-sm btn-danger" data-toggle="modal"
                                                data-target="#cancelModal{{ $assignment->id }}"
                                                title="Cancelar asignación">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                    @else
                                        <span class="text-muted">Sin acciones</span>
                                    @endif
                                </td>
                            </tr>

                            <!-- Modal de Cancelación -->
                            @if ($assignment->activo)
                                <div class="modal fade" id="cancelModal{{ $assignment->id }}" tabindex="-1" role="dialog"
                                    aria-labelledby="cancelModalLabel{{ $assignment->id }}" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header bg-danger">
                                                <h5 class="modal-title text-white"
                                                    id="cancelModalLabel{{ $assignment->id }}">
                                                    <i class="fas fa-exclamation-triangle"></i> Cancelar Asignación
                                                </h5>
                                                <button type="button" class="close text-white" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="text-center mb-3">
                                                    <i class="fas fa-exclamation-circle fa-3x text-warning"></i>
                                                </div>
                                                <h5 class="text-center mb-3">¿Estás seguro de cancelar esta asignación?</h5>
                                                <div class="alert alert-info">
                                                    <strong>Lead:</strong> #{{ $assignment->lead->id }} -
                                                    {{ $assignment->lead->cliente->nombre_completo }}<br>
                                                    <strong>Asesor:</strong> {{ $assignment->asignado->name }}<br>
                                                    <strong>Fecha de asignación:</strong>
                                                    {{ $assignment->fecha_asignacion->format('d/m/Y H:i') }}
                                                </div>
                                                <p class="text-muted">Esta acción cambiará el estado de la asignación a
                                                    "Cancelado" y permitirá que el lead sea asignado nuevamente.</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                                    <i class="fas fa-times"></i> No, mantener
                                                </button>
                                                <form action="{{ route('leads.assign.destroy', $assignment) }}"
                                                    method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">
                                                        <i class="fas fa-check"></i> Sí, cancelar asignación
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
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

@section('css')
    <style>
        .btn-group .btn {
            margin-right: 2px;
        }

        .btn-group .btn:last-child {
            margin-right: 0;
        }

        .modal-header.bg-danger .close {
            color: white;
            opacity: 0.8;
        }

        .modal-header.bg-danger .close:hover {
            opacity: 1;
        }
    </style>
@stop

@section('js')
    <script>
        $(document).ready(function() {
            // Confirmación adicional para el envío del formulario de cancelación
            $('form[action*="destroy"]').on('submit', function(e) {
                e.preventDefault();

                Swal.fire({
                    title: '¿Confirmar cancelación?',
                    text: 'Esta acción no se puede deshacer',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Sí, cancelar',
                    cancelButtonText: 'No, mantener'
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.submit();
                    }
                });
            });
        });
    </script>
@stop
