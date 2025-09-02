@extends('adminlte::page')

@section('title', 'Asignar Lead')

@section('content_header')
    <h1>Asignar Lead a Asesor</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('leads.assign.store') }}" method="POST">
                @csrf
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="lead_id">Seleccionar Lead*</label>
                            <select name="lead_id" id="lead_id" class="form-control select2" required
                                    onchange="window.location.href='{{ route('leads.assign.create') }}?lead_id=' + this.value">
                                <option value="">Seleccione un lead</option>
                                @foreach($leads as $leadOption)
                                    <option value="{{ $leadOption->id }}" 
                                        {{ $lead && $lead->id == $leadOption->id ? 'selected' : '' }}>
                                        #{{ $leadOption->id }} - {{ $leadOption->cliente->nombre_completo }} 
                                        ({{ $leadOption->tipo->nombre_tipo }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                @if($lead)
                <div class="row mt-3">
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
                                        <strong>Email:</strong> {{ $lead->cliente->correo ?? 'N/A' }}
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

                <div class="row mt-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="usuario_asignado_id">Asignar a*</label>
                            <select name="usuario_asignado_id" id="usuario_asignado_id" class="form-control select2" required>
                                <option value="">Seleccione un asesor</option>
                                @foreach($availableAdvisors as $advisor)
                                    <option value="{{ $advisor->id }}">
                                        {{ $advisor->name }} - 
                                        {{ $advisor->roles->first()->name }} - 
                                        {{ $advisor->laboral->sedes->first()->nombre_sede ?? 'Sin sede' }}
                                    </option>
                                @endforeach
                            </select>
                            @if($availableAdvisors->isEmpty())
                                <div class="alert alert-warning mt-2">
                                    No hay asesores disponibles para este tipo de lead en sus sedes.
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="observacion">Observación</label>
                            <textarea name="observacion" id="observacion" class="form-control" rows="3" 
                                      placeholder="Observaciones sobre la asignación"></textarea>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('leads.assign') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Cancelar
                    </a>
                    <button type="submit" class="btn btn-primary" {{ $availableAdvisors->isEmpty() ? 'disabled' : '' }}>
                        <i class="fas fa-save"></i> Asignar Lead
                    </button>
                </div>
                @else
                <div class="alert alert-info mt-3">
                    Por favor, seleccione un lead para continuar con la asignación.
                </div>
                @endif
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