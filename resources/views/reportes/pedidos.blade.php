@extends('layouts.app')

@section('content')
<div class="container page-shell">
    <div class="page-header">
        <div>
            <p class="page-eyebrow">Reportes</p>
            <h1 class="page-title">Reporte de pedidos</h1>
            <p class="page-description">Vista general de los pedidos y sus clientes asociados.</p>
        </div>
        <div class="d-flex flex-wrap gap-2">
            <a href="{{ route('reportes.pedidos.pdf') }}" class="btn btn-dark">Descargar PDF</a>
            <a href="{{ route('pedidos.index') }}" class="btn btn-outline-secondary">Administrar pedidos</a>
        </div>
    </div>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span>Pedidos</span>
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
                        </tr>
                    @empty
                        <tr><td colspan="5" class="empty-state">No hay pedidos para mostrar.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
