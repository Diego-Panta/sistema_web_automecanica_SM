@extends('adminlte::page')

@section('title', 'Listado de Leads')

@section('content_header')
    <h1 class="mb-4">Listado de Leads</h1>
    <div class="d-flex justify-content-between">
        <a href="{{ route('leads.create.manual') }}" class="btn btn-primary">
            <i class="fas fa-plus-circle"></i> Nuevo Lead Manual
        </a>
        <div>
            <a href="#" class="btn btn-outline-secondary">
                <i class="fas fa-file-import"></i> Importar
            </a>
            <a href="#" class="btn btn-outline-secondary">
                <i class="fas fa-filter"></i> Filtros
            </a>
        </div>
    </div>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>ID</th>
                            <th>Cliente</th>
                            <th>Tipo</th>
                            <th>Estado</th>
                            <th>Canal</th>
                            <th>Sede</th>
                            <th>Fecha Creación</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($leads as $lead)
                            <tr>
                                <td>{{ $lead->id }}</td>
                                <td>
                                    <a href="{{ route('clientes.show', $lead->cliente_id) }}" target="_blank">
                                        {{ $lead->cliente->nombre_completo }}
                                    </a>
                                </td>
                                <td>
                                    <span class="badge"
                                        style="background-color: {{ $lead->tipo->color ?? '#6c757d' }}; color: white;">
                                        {{ $lead->tipo->nombre_tipo }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge badge-{{ $lead->estadoActual->clase ?? 'secondary' }}">
                                        {{ $lead->estadoActual->nombre_estado }}
                                    </span>
                                </td>
                                <td>{{ $lead->canal->nombre_canal }}</td>
                                <td>
                                    {{ $lead->sede ? $lead->sede->nombre_sede : 'N/A' }}
                                </td>
                                <td>{{ $lead->created_at->format('d/m/Y H:i') }}</td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('leads.show', $lead) }}" class="btn btn-sm btn-info"
                                            title="Ver">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('leads.edit', $lead) }}" class="btn btn-sm btn-primary"
                                            title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('leads.destroy', $lead) }}" method="POST"
                                            style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Eliminar"
                                                onclick="return confirm('¿Estás seguro de eliminar este lead?')">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">No hay leads registrados</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer">
            {{ $leads->links() }}
        </div>
    </div>
@stop

@section('css')
    <style>
        .badge {
            font-size: 0.9em;
            padding: 0.35em 0.65em;
        }

        .table-responsive {
            overflow-x: auto;
        }

        .btn-group {
            display: flex;
            gap: 5px;
        }
    </style>
@stop

@section('js')
    <script>
        $(document).ready(function() {
            // Mostrar tooltips
            $('[title]').tooltip();

            // Confirmación antes de eliminar
            $('form').submit(function(e) {
                if ($(this).hasClass('delete-form')) {
                    e.preventDefault();
                    if (confirm('¿Estás seguro de eliminar este lead?')) {
                        this.submit();
                    }
                }
            });
        });
    </script>
@stop
