@extends('adminlte::page')

@section('title', 'Editar Asignación de Lead')

@section('content_header')
    <h1>Editar Asignación de Lead</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('leads.assign.update', $lead) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title">Información del Lead</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <strong>Cliente:</strong> {{ $lead->cliente->nombre_completo }}<br>
                                        <strong>Teléfono:</strong> {{ $lead->cliente->celular }}<br>
                                        <strong>Email:</strong> {{ $lead->cliente->correo ?? 'N/A' }}<br>
                                        <strong>Sede:</strong> {{ $lead->sede->nombre_sede ?? 'N/A' }}
                                    </div>
                                    <div class="col-md-4">
                                        <strong>Tipo:</strong> 
                                        <span class="badge badge-{{ $lead->tipo->badge_color ?? 'secondary' }}">
                                            {{ $lead->tipo->nombre_tipo }}
                                        </span><br>
                                        <strong>Canal:</strong> {{ $lead->canal->nombre_canal ?? 'N/A' }}<br>
                                        <strong>Fecha creación:</strong> {{ $lead->created_at->format('d/m/Y H:i') }}
                                    </div>
                                    <div class="col-md-4">
                                        @foreach($lead->getCamposEspecificos() as $key => $value)
                                            <strong>{{ ucfirst(str_replace('_', ' ', $key)) }}:</strong> 
                                            {{ $value }}<br>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @if($currentAssignment)
                <div class="row mt-3">
                    <div class="col-md-12">
                        <div class="card card-warning">
                            <div class="card-header">
                                <h3 class="card-title">Asignación Actual</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <strong>Asesor asignado:</strong> {{ $currentAssignment->asignado->name }}<br>
                                        <strong>Rol:</strong> {{ $currentAssignment->asignado->roles->first()->name }}<br>
                                        <strong>Sede:</strong> {{ $currentAssignment->asignado->laborale->sede->nombre_sede ?? 'N/A' }}
                                    </div>
                                    <div class="col-md-6">
                                        <strong>Asignado por:</strong> {{ $currentAssignment->asignador->name }}<br>
                                        <strong>Fecha de asignación:</strong> {{ $currentAssignment->fecha_asignacion->format('d/m/Y H:i') }}<br>
                                        <strong>Observación:</strong> {{ $currentAssignment->observacion ?? 'Sin observación' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <div class="row mt-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="usuario_asignado_id">Reasignar a*</label>
                            <select name="usuario_asignado_id" id="usuario_asignado_id" class="form-control select2" required>
                                <option value="">Seleccione un asesor</option>
                                @foreach($availableAdvisors as $advisor)
                                    <option value="{{ $advisor->id }}" {{ $currentAssignment && $currentAssignment->usuario_asignado_id == $advisor->id ? 'selected' : '' }}>
                                        {{ $advisor->name }} - 
                                        {{ $advisor->roles->first()->name }} - 
                                        {{ $advisor->laborale->sede->nombre_sede ?? 'Sin sede' }}
                                    </option>
                                @endforeach
                            </select>
                            @if($availableAdvisors->isEmpty())
                                <div class="alert alert-warning mt-2">
                                    No hay asesores disponibles para este tipo de lead en la sede {{ $lead->sede->nombre_sede }}.
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="observacion">Nueva Observación</label>
                            <textarea name="observacion" id="observacion" class="form-control" rows="3" 
                                      placeholder="Observaciones sobre la reasignación">{{ old('observacion') }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('leads.assign') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Cancelar
                    </a>
                    <button type="submit" class="btn btn-primary" {{ $availableAdvisors->isEmpty() ? 'disabled' : '' }}>
                        <i class="fas fa-save"></i> Actualizar Asignación
                    </button>
                </div>
            </form>
        </div>
    </div>
@stop

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                theme: 'bootstrap4'
            });
        });
    </script>
@stop