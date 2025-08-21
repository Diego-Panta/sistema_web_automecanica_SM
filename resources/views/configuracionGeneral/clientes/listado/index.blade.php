@extends('adminlte::page')

@section('title', 'Listado de Clientes')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Listado de Clientes</h1>
        <a href="{{ route('clientes.create') }}" class="btn btn-primary">
            <i class="fas fa-plus-circle"></i> Nuevo Cliente
        </a>
    </div>
@stop

@section('content')
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover" id="clientes-table">
                    <thead class="thead-dark">
                        <tr>
                            <th>ID</th>
                            <th>Nombre Completo</th>
                            <th>DNI</th>
                            <th>Celular</th>
                            <th>Estado</th>
                            <th>Leads</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($clientes as $cliente)
                                <tr>
                                    <td>{{ $cliente->id }}</td>
                                    <td>{{ $cliente->nombre_completo }}</td>
                                    <td>{{ $cliente->dni ?? 'N/A' }}</td>
                                    <td>{{ $cliente->celular ?? 'N/A' }}</td>
                                    <td>
                                        @if ($cliente->estado)
                                            @if ($cliente->estado->nombre_estado == 'Activo')
                                                <span
                                                    class="badge badge-success">{{ $cliente->estado->nombre_estado }}</span>
                                            @elseif($cliente->estado->nombre_estado == 'Inactivo')
                                                <span
                                                    class="badge badge-danger">{{ $cliente->estado->nombre_estado }}</span>
                                            @else
                                                <span
                                                    class="badge badge-{{ $cliente->estado->clase ?? 'warning' }}">{{ $cliente->estado->nombre_estado }}</span>
                                            @endif
                                        @else
                                            <span class="badge badge-secondary">Sin estado</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge badge-info">{{ $cliente->leads->count() }}</span>
                                    </td>
                                    <td width="160px">
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('clientes.show', $cliente) }}" class="btn btn-sm btn-info"
                                                title="Ver">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('clientes.edit', $cliente) }}" class="btn btn-sm btn-warning"
                                                title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            @if ($cliente->estado && $cliente->estado->nombre_estado == 'Activo')
                                                <button type="button" class="btn btn-sm btn-danger" title="Desactivar"
                                                    onclick="setToggleData({{ $cliente->id }}, '{{ $cliente->nombre_completo }}', 'desactivar', {{ $cliente->leads->count() }})"
                                                    data-toggle="modal" data-target="#toggleModal">
                                                    <i class="fas fa-user-times"></i>
                                                </button>
                                            @else
                                                <button type="button" class="btn btn-sm btn-success" title="Reestablecer"
                                                    onclick="setToggleData({{ $cliente->id }}, '{{ $cliente->nombre_completo }}', 'reestablecer', {{ $cliente->leads->count() }})"
                                                    data-toggle="modal" data-target="#toggleModal">
                                                    <i class="fas fa-user-check"></i>
                                                </button>
                                            @endif
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
            {{ $clientes->links() }}
        </div>
    </div>

    <!-- Modal de confirmación para activar/desactivar -->
    <div class="modal fade" id="toggleModal" tabindex="-1" role="dialog" aria-labelledby="toggleModalLabel"
        aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" id="toggleModalHeader">
                    <h5 class="modal-title" id="toggleModalLabel">Confirmar Acción</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" tabindex="-1">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <span id="toggleMessage"></span>
                    <div id="leadsWarning" class="alert alert-warning mt-3" style="display: none;">
                        <i class="fas fa-exclamation-triangle"></i>
                        <span id="leadsWarningText"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <form id="toggleForm" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn" id="toggleConfirmBtn">Confirmar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <style>
        .badge {
            font-size: 0.9em;
            padding: 0.35em 0.65em;
        }

        .btn-group {
            display: flex;
            gap: 3px;
        }

        .alert-warning {
            margin-bottom: 0;
        }

        .table th,
        .table td {
            vertical-align: middle;
        }
    </style>
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Mostrar alertas SweetAlert2 si hay mensajes de sesión
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: '¡Éxito!',
                text: '{{ session('success') }}',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true
            });
        @endif

        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: '¡Error!',
                text: '{{ session('error') }}',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 5000,
                timerProgressBar: true
            });
        @endif
    </script>
    <script>
        function setToggleData(id, nombre, action, leadsCount) {
            const modal = document.getElementById('toggleModal');
            const header = document.getElementById('toggleModalHeader');
            const message = document.getElementById('toggleMessage');
            const confirmBtn = document.getElementById('toggleConfirmBtn');
            const form = document.getElementById('toggleForm');
            const leadsWarning = document.getElementById('leadsWarning');
            const leadsWarningText = document.getElementById('leadsWarningText');

            // Configurar el formulario
            form.action = '{{ route('clientes.destroy', '') }}/' + id;

            if (action === 'desactivar') {
                header.className = 'modal-header bg-warning text-dark';
                message.innerHTML =
                    `¿Estás seguro de <strong>desactivar</strong> al cliente "<strong>${nombre}</strong>"?<br><small class="text-muted">El cliente quedará inactivo pero conservará todos sus datos.</small>`;
                confirmBtn.className = 'btn btn-warning';
                confirmBtn.textContent = 'Desactivar Cliente';

                // Mostrar advertencia sobre leads si tiene
                if (leadsCount > 0) {
                    leadsWarningText.textContent =
                        `Este cliente tiene ${leadsCount} leads asociados que también pueden verse afectados.`;
                    leadsWarning.style.display = 'block';
                } else {
                    leadsWarning.style.display = 'none';
                }
            } else {
                header.className = 'modal-header bg-success text-white';
                message.innerHTML =
                    `¿Estás seguro de <strong>reestablecer</strong> al cliente "<strong>${nombre}</strong>"?<br><small class="text-muted">El cliente volverá a estar activo en el sistema.</small>`;
                confirmBtn.className = 'btn btn-success';
                confirmBtn.textContent = 'Reestablecer Cliente';
                leadsWarning.style.display = 'none';
            }
        }

        $(document).ready(function() {
            // Inicializar DataTable
            $('#clientes-table').DataTable({
                responsive: true,
                autoWidth: false,
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json'
                },
                order: [
                    [0, 'desc']
                ] // Ordenar por ID descendente por defecto
            });

            // Mostrar tooltips
            $('[title]').tooltip();
        });
    </script>
@stop
