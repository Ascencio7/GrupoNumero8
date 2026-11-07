@extends('layouts.app')

@section('content')
<div class="container page-shell">
    <div class="page-header">
        <div>
            <p class="page-eyebrow">Reportes</p>
            <h1 class="page-title">Directorio de clientes</h1>
            <p class="page-description">Vista general de los clientes registrados.</p>
        </div>
        <div class="d-flex flex-wrap gap-2">
            <a href="{{ route('reportes.clientes.pdf') }}" class="btn btn-dark">Descargar PDF</a>
            <a href="{{ route('clientes.index') }}" class="btn btn-outline-secondary">Administrar clientes</a>
        </div>
    </div>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span>Clientes</span>
            <span class="badge rounded-pill text-bg-light">{{ $clientes->count() }} registros</span>
        </div>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Nombre completo</th>
                        <th scope="col">Fecha de nacimiento</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($clientes as $cliente)
                        <tr>
                            <td class="text-secondary">#{{ $cliente->Id_Cliente }}</td>
                            <td class="fw-semibold">{{ $cliente->Nombre }} {{ $cliente->Apellido }}</td>
                            <td>{{ $cliente->Fecha_Nac }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="3" class="empty-state">No hay clientes para mostrar.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
