@extends('layouts.app')

@section('content')
<div class="container page-shell">
    <div class="page-header">
        <div>
            <p class="page-eyebrow">Reportes</p>
            <h1 class="page-title">Pedidos por cliente</h1>
            <p class="page-description">Selecciona un cliente para consultar sus pedidos.</p>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">Criterios del reporte</div>
        <div class="card-body">
            <form action="{{ route('reportes.por_cliente') }}" method="GET" class="row g-3 align-items-end">
                <div class="col-md-8">
                    <label for="Id_Cliente" class="form-label">Cliente</label>
                    <select name="Id_Cliente" id="Id_Cliente" class="form-select" required>
                        <option value="">Selecciona un cliente</option>
                        @foreach($clientes as $cliente)
                            <option value="{{ $cliente->Id_Cliente }}" {{ request('Id_Cliente') == $cliente->Id_Cliente ? 'selected' : '' }}>
                                {{ $cliente->Nombre }} {{ $cliente->Apellido }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary w-100">Generar reporte</button>
                </div>
            </form>
        </div>
    </div>

    @if(request()->has('Id_Cliente'))
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center gap-2">
                <span>Resultados del reporte</span>
                <a href="{{ route('reportes.por_cliente.pdf', ['Id_Cliente' => request('Id_Cliente')]) }}" class="btn btn-dark btn-sm">Descargar PDF</a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">ID pedido</th>
                            <th scope="col">Fecha del pedido</th>
                            <th scope="col">Fecha de entrega</th>
                            <th scope="col">Observaciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pedidos as $pedido)
                            <tr>
                                <td class="text-secondary">#{{ $pedido->Id_Pedido }}</td>
                                <td>{{ $pedido->FechaPedido }}</td>
                                <td>{{ $pedido->FechaEntrega }}</td>
                                <td>{{ $pedido->Observaciones ?? 'Ninguna' }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="empty-state">Este cliente no tiene pedidos registrados.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>
@endsection
