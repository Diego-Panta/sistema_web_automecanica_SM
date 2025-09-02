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
    <!-- Eliminar el script inline y reemplazar con esto -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>¡Éxito!</strong> {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>¡Error!</strong> {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
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
                            <th>Código Trabajador</th>
                            <th>Estado</th>
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
                                <td>{{ $user->laborale->codigo_trabajador ?? 'N/A' }}</td>
                                <td>
                                    @if ($user->laborale && $user->laborale->estado)
                                        <span
                                            class="badge badge-success">{{ $user->laborale->estado->nombre_estado }}</span>
                                    @else
                                        <span class="badge badge-secondary">Sin estado</span>
                                    @endif
                                </td>
                                <td>
                                    @forelse($user->roles as $role)
                                        <span class="badge bg-primary">{{ $role->name }}</span>
                                    @empty
                                        <span class="badge bg-secondary">Sin roles</span>
                                    @endforelse
                                </td>
                                <td width="180px">
                                    <div class="d-flex flex-wrap gap-1">
                                        <a href="{{ route('users.edit', $user) }}" class="btn btn-sm btn-warning mr-1"
                                            title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        @if ($user->laborale && $user->laborale->estado && $user->laborale->estado->nombre_estado == 'Activo')
                                            <button type="button" class="btn btn-sm btn-danger mr-1" title="Desactivar"
                                                onclick="setToggleData({{ $user->id }}, '{{ $user->name }}', 'desactivar')"
                                                data-toggle="modal" data-target="#toggleModal">
                                                <i class="fas fa-user-times"></i>
                                            </button>
                                        @else
                                            <button type="button" class="btn btn-sm btn-success mr-1" title="Reestablecer"
                                                onclick="setToggleData({{ $user->id }}, '{{ $user->name }}', 'reestablecer')"
                                                data-toggle="modal" data-target="#toggleModal">
                                                <i class="fas fa-user-check"></i>
                                            </button>
                                        @endif
                                        <button type="button" class="btn btn-sm btn-info mr-1" title="Ver datos laborales"
                                            onclick='showLaboralModal(@json($user))'>
                                            <i class="fas fa-briefcase"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-secondary" title="Ver horarios"
                                            onclick='showHorariosModal(@json($user))'>
                                            <i class="fas fa-clock"></i>
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

    <!-- Modal: Horarios del Usuario -->
    <div class="modal fade" id="horariosModal" tabindex="-1" role="dialog" aria-labelledby="horariosModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title" id="horariosModalLabel">Horarios del Usuario</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h6 class="mb-3">Usuario: <span id="horarios-usuario-nombre"></span></h6>
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm">
                            <thead class="thead-light">
                                <tr>
                                    <th>Día</th>
                                    <th>Sede</th>
                                    <th>Turno</th>
                                </tr>
                            </thead>
                            <tbody id="horarios-tbody">
                                <!-- Los horarios se cargarán aquí dinámicamente -->
                            </tbody>
                        </table>
                    </div>
                    <div id="no-horarios" class="alert alert-info" style="display: none;">
                        <i class="fas fa-info-circle"></i> Este usuario no tiene horarios asignados.
                    </div>
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
        //Se repite con cliente
        function setToggleData(id, nombre, action) {
            const modal = document.getElementById('toggleModal');
            const header = document.getElementById('toggleModalHeader');
            const message = document.getElementById('toggleMessage');
            const confirmBtn = document.getElementById('toggleConfirmBtn');
            const form = document.getElementById('toggleForm');

            // Configurar el formulario
            form.action = '{{ route('users.destroy', '') }}/' + id;

            if (action === 'desactivar') {
                header.className = 'modal-header bg-warning text-dark';
                message.innerHTML =
                    `¿Estás seguro de <strong>desactivar</strong> al usuario "<strong>${nombre}</strong>"?<br><small class="text-muted">El usuario no podrá acceder al sistema pero conservará todos sus datos.</small>`;
                confirmBtn.className = 'btn btn-warning';
                confirmBtn.textContent = 'Desactivar Usuario';
            } else {
                header.className = 'modal-header bg-success text-white';
                message.innerHTML =
                    `¿Estás seguro de <strong>reestablecer</strong> al usuario "<strong>${nombre}</strong>"?<br><small class="text-muted">El usuario podrá acceder nuevamente al sistema.</small>`;
                confirmBtn.className = 'btn btn-success';
                confirmBtn.textContent = 'Reestablecer Usuario';
            }
        }
        /////////////////////////////////////////////////////////

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

        function showLaboralModal(user) {
            const laboral = user.laborale || {};
            const estado = laboral.estado || {};

            document.getElementById('modal-nombre').textContent = user.name || 'N/A';
            document.getElementById('modal-codigo').textContent = laboral.codigo_trabajador || 'N/A';
            document.getElementById('modal-estado').textContent = estado.nombre_estado || 'N/A';
            document.getElementById('modal-inicio').textContent = laboral.fecha_contratacion_inicio || 'N/A';
            document.getElementById('modal-fin').textContent = laboral.fecha_contratacion_fin || 'N/A';

            $('#laboralModal').modal('show');
        }

        function showHorariosModal(user) {
            const diasSemana = {
                'lunes': 'Lunes',
                'martes': 'Martes',
                'miercoles': 'Miércoles',
                'jueves': 'Jueves',
                'viernes': 'Viernes',
                'sabado': 'Sábado',
                'domingo': 'Domingo'
            };

            document.getElementById('horarios-usuario-nombre').textContent = user.name || 'N/A';
            const tbody = document.getElementById('horarios-tbody');
            const noHorarios = document.getElementById('no-horarios');

            // Limpiar contenido anterior
            tbody.innerHTML = '';

            const horarios = user.laborale && user.laborale.horarios ? user.laborale.horarios : [];
            const sede = user.laborale && user.laborale.sede ? user.laborale.sede.nombre_sede : 'N/A';

            if (horarios.length > 0) {
                noHorarios.style.display = 'none';

                horarios.forEach(horario => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                <td>${diasSemana[horario.dia_semana] || horario.dia_semana}</td>
                <td>${sede}</td> <!-- MOSTRAR SEDE DESDE EMPLEADO -->
                <td>${horario.turno ? horario.turno.nombre_turno : 'N/A'}</td>
            `;
                    tbody.appendChild(row);
                });
            } else {
                noHorarios.style.display = 'block';
            }

            $('#horariosModal').modal('show');
        }
    </script>
@stop
