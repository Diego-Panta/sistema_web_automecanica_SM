@extends('adminlte::page')

@section('title', 'Listado de Clientes')

@section('content_header')
    <h1>Listado de Clientes</h1>
    <a href="{{ route('clientes.create') }}" class="btn btn-primary">
        <i class="fas fa-plus-circle"></i> Nuevo Cliente
    </a>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre Completo</th>
                        <th>DNI</th>
                        <th>Celular</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($clientes as $cliente)
                        <tr>
                            <td>{{ $cliente->id }}</td>
                            <td>{{ $cliente->nombre_completo }}</td>
                            <td>{{ $cliente->dni ?? 'N/A' }}</td>
                            <td>{{ $cliente->celular ?? 'N/A' }}</td>
                            <td>
                                <span class="badge badge-{{ $cliente->estado->clase ?? 'secondary' }}">
                                    {{ $cliente->estado->nombre_estado }}
                                </span>
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('clientes.show', $cliente) }}" class="btn btn-sm btn-info" title="Ver">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('clientes.edit', $cliente) }}" class="btn btn-sm btn-primary" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button class="btn btn-sm btn-danger" title="Eliminar" data-toggle="modal" data-target="#deleteModal{{ $cliente->id }}">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <!-- Modal de Eliminación -->
                        <div class="modal fade" id="deleteModal{{ $cliente->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header bg-danger">
                                        <h5 class="modal-title" id="deleteModalLabel">Confirmar Eliminación</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        ¿Estás seguro de eliminar al cliente <strong>{{ $cliente->nombre_completo }}</strong>?
                                        @if($cliente->leads->count() > 0)
                                            <div class="alert alert-warning mt-2">
                                                <i class="fas fa-exclamation-triangle"></i> Este cliente tiene {{ $cliente->leads->count() }} leads asociados que también se eliminarán.
                                            </div>
                                        @endif
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                        <form action="{{ route('clientes.destroy', $cliente) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">
                                                <i class="fas fa-trash-alt"></i> Eliminar
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            {{ $clientes->links() }}
        </div>
    </div>
@stop

@section('css')
    <style>
        .badge {
            font-size: 0.9em;
            padding: 0.35em 0.65em;
        }
        .btn-group {
            display: flex;
            gap: 5px;
        }
        .modal-header.bg-danger {
            color: white;
        }
        .alert-warning {
            margin-bottom: 0;
        }
    </style>
@stop

@section('js')
    <script>
        $(document).ready(function() {
            // Mostrar tooltips
            $('[title]').tooltip();
            
            // Si hay errores de validación, mostrar el modal correspondiente
            @if($errors->any())
                $('#createModal').modal('show');
            @endif
        });
    </script>
@stop