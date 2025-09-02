@extends('adminlte::page')

@section('title', 'Asignación de Leads')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Leads para Asignar</h1>
        <a href="{{ route('leads.assign.create') }}" class="btn btn-primary">
            <i class="fas fa-plus-circle"></i> Nueva Asignación
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
                <table class="table table-striped table-hover" id="leads-table">
                    <thead class="thead-dark">
                        <tr>
                            <th>ID</th>
                            <th>Cliente</th>
                            <th>Tipo</th>
                            <th>Estado</th>
                            <th>Fecha Creación</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($leads as $lead)
                            <tr>
                                <td>{{ $lead->id }}</td>
                                <td>{{ $lead->cliente->nombre_completo ?? 'N/A' }}</td>
                                <td>
                                    <span class="badge badge-{{ $lead->tipo->badge_color ?? 'secondary' }}">
                                        {{ $lead->tipo->nombre_tipo }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge badge-{{ $lead->estadoActual->badge_color ?? 'secondary' }}">
                                        {{ $lead->estadoActual->nombre_estado }}
                                    </span>
                                </td>
                                <td>{{ $lead->created_at->format('d/m/Y H:i') }}</td>
                                <td width="120px">
                                    <div class="d-flex">
                                        <a href="{{ route('leads.assign.create', ['lead_id' => $lead->id]) }}" 
                                           class="btn btn-sm btn-primary mr-2" title="Asignar">
                                            <i class="fas fa-user-plus"></i>
                                        </a>
                                        <a href="{{ route('leads.show', $lead) }}" 
                                           class="btn btn-sm btn-info" title="Ver detalles">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center mt-3">
                {{ $leads->links() }}
            </div>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script>
        $(document).ready(function() {
            $('#leads-table').DataTable({
                "paging": false,
                "searching": true,
                "ordering": true,
                "info": false,
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.25/i18n/Spanish.json"
                }
            });
        });
    </script>
@stop