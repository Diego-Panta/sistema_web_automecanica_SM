@extends('adminlte::page')

@section('title', 'Canales de Lead')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Canales de Lead</h1>
        <a href="{{ route('leads.channels.create') }}" class="btn btn-primary">
            <i class="fas fa-plus-circle"></i> Nuevo Canal
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
                <table class="table table-striped table-hover" id="canales-table">
                    <thead class="thead-dark">
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($canales as $canal)
                            <tr>
                                <td>{{ $canal->id }}</td>
                                <td>{{ $canal->nombre_canal }}</td>
                                <td width="120px">
                                    <div class="d-flex">
                                        <a href="{{ route('leads.channels.edit', $canal) }}"
                                            class="btn btn-sm btn-warning mr-2">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-danger"
                                            onclick="setDeleteData({{ $canal->id }}, '{{ $canal->nombre_canal }}')"
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
                    ¿Estás seguro de eliminar el canal "<span id="canalName"></span>"?
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function setDeleteData(id, nombre) {
            document.getElementById('canalName').textContent = nombre;
            document.getElementById('deleteForm').action = '{{ route('leads.channels.destroy', '') }}/' + id;
        }
    </script>
@stop