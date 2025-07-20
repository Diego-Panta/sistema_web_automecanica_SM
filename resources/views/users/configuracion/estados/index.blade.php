@extends('adminlte::page')

@section('title', 'Estados de usuarios')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Estados de Usuarios</h1>
        <a href="{{ route('users.status.create') }}" class="btn btn-primary">
            <i class="fas fa-plus-circle"></i> Nuevo Estado
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
                title: "Operación exitosa"
            });
        </script>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover" id="estados-table">
                    <thead class="thead-dark">
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($estados as $estado)
                            <tr>
                                <td>{{ $estado->id }}</td>
                                <td>{{ $estado->nombre_estado }}</td>
                                <td width="120px">
                                    <div class="d-flex">
                                        <!-- Botón Editar -->
                                        <a href="{{ route('users.status.edit', $estado) }}"
                                            class="btn btn-sm btn-warning mr-2">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <!-- Botón Eliminar -->
                                        <button type="button" class="btn btn-sm btn-danger"
                                            onclick="setDeleteData({{ $estado->id }}, '{{ $estado->nombre_estado }}')"
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
    <!-- Modal de eliminacion -->
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
                    ¿Estás seguro de eliminar el estado de usuario "<span id="estadoName"></span>"?
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@stop

@section('js')
    <!-- SweetAlert2 si lo necesitas -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function setDeleteData(id, nombre) {
            document.getElementById('estadoName').textContent = nombre;
            document.getElementById('deleteForm').action = '{{ route('users.status.destroy', '') }}/' + id;
        }
    </script>
@stop