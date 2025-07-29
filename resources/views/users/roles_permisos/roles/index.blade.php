@extends('adminlte::page')

@section('title', 'Listado de Roles')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Listado de Roles</h1>
        <a href="{{ route('users.roles.create') }}" class="btn btn-primary">
            <i class="fas fa-plus-circle"></i> Nuevo Rol
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
                <table class="table table-striped table-hover" id="roles-table">
                    <thead class="thead-dark">
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Guard</th>
                            <th>Permisos</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($roles as $role)
                            <tr>
                                <td>{{ $role->id }}</td>
                                <td>{{ $role->name }}</td>
                                <td>{{ $role->guard_name }}</td>
                                <td>
                                    @forelse($role->permissions as $permission)
                                        <span class="badge bg-info">{{ $permission->name }}</span>
                                    @empty
                                        <span class="badge bg-secondary">Sin permisos</span>
                                    @endforelse
                                </td>
                                <td width="150px">
                                    <div class="d-flex">
                                        <a href="{{ route('users.roles.edit', $role) }}"
                                            class="btn btn-sm btn-warning mr-2">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="{{ route('users.role-permissions.edit', $role) }}"
                                            class="btn btn-sm btn-info mr-2">
                                            <i class="fas fa-key"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-danger"
                                            onclick="setDeleteData({{ $role->id }}, '{{ $role->name }}')"
                                            data-toggle="modal" data-target="#deleteModal">
                                            <i class="fas fa-trash"></i>
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
                    ¿Estás seguro de eliminar el rol "<span id="roleName"></span>"?
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
@stop

@section('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function setDeleteData(id, nombre) {
            document.getElementById('roleName').textContent = nombre;
            document.getElementById('deleteForm').action = '{{ route('users.roles.destroy', '') }}/' + id;
        }
        
        // Inicializar DataTable
        $(document).ready(function() {
            $('#roles-table').DataTable({
                responsive: true,
                autoWidth: false,
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json'
                }
            });
        });
    </script>
@stop