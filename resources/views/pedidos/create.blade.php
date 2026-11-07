@extends('layouts.app')

@section('content')
<div class="container page-shell">
    <div class="page-header">
        <div>
            <p class="page-eyebrow">Operaciones</p>
            <h1 class="page-title">Nuevo pedido</h1>
            <p class="page-description">Ingresa las fechas y el cliente asociado al pedido.</p>
        </div>
        <a href="{{ route('pedidos.index') }}" class="btn btn-outline-secondary">Volver al listado</a>
    </div>

    <div class="card">
        <div class="card-header">Información del pedido</div>
        <div class="card-body">
            @if($errors->any())
                <div class="alert alert-danger">
                    <p class="fw-semibold mb-1">Revisa la información ingresada:</p>
                    <ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                </div>
            @endif

            <form action="{{ route('pedidos.store') }}" method="POST">
                @csrf
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="FechaPedido" class="form-label">Fecha del pedido</label>
                        <input type="datetime-local" name="FechaPedido" id="FechaPedido" value="{{ old('FechaPedido') }}" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label for="FechaEntrega" class="form-label">Fecha de entrega</label>
                        <input type="datetime-local" name="FechaEntrega" id="FechaEntrega" value="{{ old('FechaEntrega') }}" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label for="Id_Cliente" class="form-label">Cliente</label>
                        <select name="Id_Cliente" id="Id_Cliente" class="form-select" required>
                            <option value="">Selecciona un cliente</option>
                            @foreach($clientes as $cliente)
                                <option value="{{ $cliente->Id_Cliente }}" {{ old('Id_Cliente') == $cliente->Id_Cliente ? 'selected' : '' }}>{{ $cliente->Nombre }} {{ $cliente->Apellido }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12">
                        <label for="Observaciones" class="form-label">Observaciones <span class="text-secondary fw-normal">(opcional)</span></label>
                        <textarea name="Observaciones" id="Observaciones" class="form-control" rows="3">{{ old('Observaciones') }}</textarea>
                    </div>
                </div>
                <div class="d-flex flex-wrap gap-2 mt-4">
                    <button type="submit" class="btn btn-primary px-4">Guardar pedido</button>
                    <a href="{{ route('pedidos.index') }}" class="btn btn-light">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
