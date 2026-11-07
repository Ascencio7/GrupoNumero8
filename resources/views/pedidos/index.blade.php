@extends('layouts.app')

@section('content')
<div class="container page-shell">
    <div class="page-header">
        <div>
            <p class="page-eyebrow">Operaciones</p>
            <h1 class="page-title">Pedidos</h1>
            <p class="page-description">Consulta y administra los pedidos registrados.</p>
        </div>
        <a href="{{ route('pedidos.create') }}" class="btn btn-primary px-3">Nuevo pedido</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span>Listado de pedidos</span>
            <span class="badge rounded-pill text-bg-light">{{ $pedidos->count() }} registros</span>
        </div>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Fecha del pedido</th>
                        <th scope="col">Fecha de entrega</th>
                        <th scope="col">Cliente</th>
                        <th scope="col">Observaciones</th>
                        <th scope="col" class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pedidos as $pedido)
                        <tr>
                            <td class="text-secondary">#{{ $pedido->Id_Pedido }}</td>
                            <td>{{ $pedido->FechaPedido }}</td>
                            <td>{{ $pedido->FechaEntrega }}</td>
                            <td class="fw-semibold">{{ $pedido->cliente->Nombre }} {{ $pedido->cliente->Apellido }}</td>
                            <td>{{ $pedido->Observaciones ?? 'Ninguna' }}</td>
                            <td class="text-end table-actions">
                                <a href="{{ route('pedidos.edit', $pedido->Id_Pedido) }}" class="btn btn-outline-primary btn-sm">Editar</a>
                                <form action="{{ route('pedidos.destroy', $pedido->Id_Pedido) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteConfirmationModal" data-delete-message="¿Está seguro de que desea eliminar este pedido? Esta acción no se puede deshacer." aria-label="Eliminar registro de pedido">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="empty-state">Todavía no hay pedidos registrados.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @include('components.delete-confirmation-modal')
</div>
@endsection
