@extends('adminlte::page')

@section('title', 'Listado de Usuarios')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Listado de Usuarios</h1>
        <a href="{{ route('users.create') }}" class="btn btn-primary">
            <i class="fas fa-user-plus"></i> Nuevo Usuario
        </a>
    </div>
@stop

@section('content')
    @if (session('success'))
        <script>
            const Toast = Swal.mixin({
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.onmouseenter = Swal.stopTimer;
                    toast.onmouseleave = Swal.resumeTimer;
                }
            });
            Toast.fire({
                icon: "success",
                title: "{{ session('success') }}"
            });
        </script>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover" id="users-table">
                    <thead class="thead-dark">
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>DNI</th>
                            <th>Celular</th>
                            <th>Roles</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->dni ?? 'N/A' }}</td>
                                <td>{{ $user->celular }}</td>
                                <td>
                                    @forelse($user->roles as $role)
                                        <span class="badge bg-primary">{{ $role->name }}</span>
                                    @empty
                                        <span class="badge bg-secondary">Sin roles</span>
                                    @endforelse
                                </td>
                                <td width="140px">
                                    <div class="d-flex flex-wrap gap-1">
                                        <a href="{{ route('users.edit', $user) }}" class="btn btn-sm btn-warning mr-1">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-danger mr-1"
                                            onclick="setDeleteData({{ $user->id }}, '{{ $user->name }}')"
                                            data-toggle="modal" data-target="#deleteModal">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-info"
                                            onclick='showLaboralModal(@json($user))'>
                                            <i class="fas fa-briefcase"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal de eliminación -->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel"
        aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="deleteModalLabel">Confirmar Eliminación</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" tabindex="-1">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    ¿Estás seguro de eliminar al usuario "<span id="userName"></span>"?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <form id="deleteForm" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Confirmar Eliminación</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal: Detalles Laborales -->
    <div class="modal fade" id="laboralModal" tabindex="-1" role="dialog" aria-labelledby="laboralModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title" id="laboralModalLabel">Datos Laborales del Usuario</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <dl class="row">
                        <dt class="col-sm-4">Nombre</dt>
                        <dd class="col-sm-8" id="modal-nombre"></dd>

                        <dt class="col-sm-4">Código de Trabajador</dt>
                        <dd class="col-sm-8" id="modal-codigo"></dd>

                        <dt class="col-sm-4">Sede</dt>
                        <dd class="col-sm-8" id="modal-sede"></dd>

                        <dt class="col-sm-4">Turno</dt>
                        <dd class="col-sm-8" id="modal-turno"></dd>

                        <dt class="col-sm-4">Estado</dt>
                        <dd class="col-sm-8" id="modal-estado"></dd>

                        <dt class="col-sm-4">Inicio de Contrato</dt>
                        <dd class="col-sm-8" id="modal-inicio"></dd>

                        <dt class="col-sm-4">Fin de Contrato</dt>
                        <dd class="col-sm-8" id="modal-fin"></dd>
                    </dl>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function setDeleteData(id, nombre) {
            document.getElementById('userName').textContent = nombre;
            document.getElementById('deleteForm').action = '{{ route('users.destroy', '') }}/' + id;
        }

        // Inicializar DataTable
        $(document).ready(function() {
            $('#users-table').DataTable({
                responsive: true,
                autoWidth: false,
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json'
                }
            });
        });
    </script>
    <script>
        function showLaboralModal(user) {
            const laboral = user.laborale || {};
            const estado = laboral.estado || {};
            const sede = laboral.sede || {};
            const turno = laboral.turno || {};

            document.getElementById('modal-nombre').textContent = user.name || 'N/A';
            document.getElementById('modal-codigo').textContent = laboral.codigo_trabajador || 'N/A';
            document.getElementById('modal-sede').textContent = sede.nombre_sede || 'N/A';
            document.getElementById('modal-turno').textContent = turno.nombre_turno || 'N/A';
            document.getElementById('modal-estado').textContent = estado.nombre_estado || 'N/A';
            document.getElementById('modal-inicio').textContent = laboral.fecha_contratacion_inicio || 'N/A';
            document.getElementById('modal-fin').textContent = laboral.fecha_contratacion_fin || 'N/A';

            $('#laboralModal').modal('show');
        }
    </script>
@stop
