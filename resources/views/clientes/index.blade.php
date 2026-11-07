@extends('layouts.app')

@section('content')
<div class="container page-shell">
    <div class="page-header">
        <div>
            <p class="page-eyebrow">Directorio</p>
            <h1 class="page-title">Clientes</h1>
            <p class="page-description">Consulta y administra los clientes registrados.</p>
        </div>
        <a href="{{ route('clientes.create') }}" class="btn btn-primary px-3">Nuevo cliente</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span>Listado de clientes</span>
            <span class="badge rounded-pill text-bg-light">{{ $clientes->count() }} registros</span>
        </div>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Apellido</th>
                        <th scope="col">Fecha de nacimiento</th>
                        <th scope="col" class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($clientes as $cliente)
                        <tr>
                            <td class="text-secondary">#{{ $cliente->Id_Cliente }}</td>
                            <td class="fw-semibold">{{ $cliente->Nombre }}</td>
                            <td>{{ $cliente->Apellido }}</td>
                            <td>{{ $cliente->Fecha_Nac }}</td>
                            <td class="text-end table-actions">
                                <a href="{{ route('clientes.edit', $cliente->Id_Cliente) }}" class="btn btn-outline-primary btn-sm">Editar</a>
                                <form action="{{ route('clientes.destroy', $cliente->Id_Cliente) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteConfirmationModal" data-delete-message="¿Está seguro de que desea eliminar este cliente? Esta acción no se puede deshacer." aria-label="Eliminar registro de cliente">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="empty-state">Todavía no hay clientes registrados.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @include('components.delete-confirmation-modal')
</div>
@endsection
