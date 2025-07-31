@extends('adminlte::page')

@section('title', 'Detalles del Cliente: ' . $cliente->nombre_completo)

@section('content_header')
    <h1>Detalles del Cliente: {{ $cliente->nombre_completo }}</h1>
    <div class="d-flex justify-content-between">
        <a href="{{ route('clientes.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Volver al listado
        </a>
        <div>
            <a href="{{ route('clientes.edit', $cliente) }}" class="btn btn-primary">
                <i class="fas fa-edit"></i> Editar
            </a>
        </div>
    </div>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h5>Información Personal</h5>
                    <hr>
                    <p><strong>Nombres:</strong> {{ $cliente->nombre }}</p>
                    <p><strong>Apellido Paterno:</strong> {{ $cliente->apellido_paterno }}</p>
                    <p><strong>Apellido Materno:</strong> {{ $cliente->apellido_materno ?? 'N/A' }}</p>
                    <p><strong>DNI:</strong> {{ $cliente->dni ?? 'N/A' }}</p>
                </div>
                <div class="col-md-6">
                    <h5>Información de Contacto</h5>
                    <hr>
                    <p><strong>Estado:</strong> 
                        <span class="badge badge-{{ $cliente->estado->clase ?? 'secondary' }}">
                            {{ $cliente->estado->nombre_estado }}
                        </span>
                    </p>
                    <p><strong>Celular:</strong> {{ $cliente->celular ?? 'N/A' }}</p>
                    <p><strong>Celular Alterno:</strong> {{ $cliente->celular_alterno ?? 'N/A' }}</p>
                    <p><strong>Correo:</strong> {{ $cliente->correo ?? 'N/A' }}</p>
                </div>
            </div>

            <div class="mt-4">
                <h5>Leads Asociados</h5>
                <hr>
                @if($cliente->leads->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Tipo</th>
                                    <th>Estado</th>
                                    <th>Fecha</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cliente->leads as $lead)
                                    <tr>
                                        <td>{{ $lead->id }}</td>
                                        <td>{{ $lead->tipo->nombre_tipo }}</td>
                                        <td>
                                            <span class="badge badge-{{ $lead->estadoActual->clase ?? 'secondary' }}">
                                                {{ $lead->estadoActual->nombre }}
                                            </span>
                                        </td>
                                        <td>{{ $lead->created_at->format('d/m/Y') }}</td>
                                        <td>
                                            <a href="{{ route('leads.show', $lead) }}" class="btn btn-xs btn-info">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-muted">Este cliente no tiene leads asociados</p>
                @endif
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
    </style>
@stop