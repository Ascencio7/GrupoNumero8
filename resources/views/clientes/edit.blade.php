@extends('layouts.app')

@section('content')
<div class="container page-shell">
    <div class="page-header">
        <div>
            <p class="page-eyebrow">Directorio · Cliente #{{ $cliente->Id_Cliente }}</p>
            <h1 class="page-title">Editar cliente</h1>
            <p class="page-description">Actualiza la información del cliente.</p>
        </div>
        <a href="{{ route('clientes.index') }}" class="btn btn-outline-secondary">Volver al listado</a>
    </div>

    <div class="card">
        <div class="card-header">Información del cliente</div>
        <div class="card-body">
            @if($errors->any())
                <div class="alert alert-danger">
                    <p class="fw-semibold mb-1">Revisa la información ingresada:</p>
                    <ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                </div>
            @endif

            <form action="{{ route('clientes.update', $cliente->Id_Cliente) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="Nombre" class="form-label">Nombre</label>
                        <input type="text" name="Nombre" id="Nombre" value="{{ old('Nombre', $cliente->Nombre) }}" class="form-control" autocomplete="given-name" required>
                    </div>
                    <div class="col-md-6">
                        <label for="Apellido" class="form-label">Apellido</label>
                        <input type="text" name="Apellido" id="Apellido" value="{{ old('Apellido', $cliente->Apellido) }}" class="form-control" autocomplete="family-name" required>
                    </div>
                    <div class="col-md-6">
                        <label for="Fecha_Nac" class="form-label">Fecha de nacimiento</label>
                        <input type="datetime-local" name="Fecha_Nac" id="Fecha_Nac" value="{{ old('Fecha_Nac', date('Y-m-d\TH:i', strtotime($cliente->Fecha_Nac))) }}" class="form-control" required>
                    </div>
                </div>
                <div class="d-flex flex-wrap gap-2 mt-4">
                    <button type="submit" class="btn btn-primary px-4">Guardar cambios</button>
                    <a href="{{ route('clientes.index') }}" class="btn btn-light">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
