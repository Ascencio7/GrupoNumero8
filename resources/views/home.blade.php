@extends('layouts.app')

@section('content')
<div class="container page-shell">
    <section class="card welcome-panel">
        <div class="card-body">
            <p class="page-eyebrow">Sistema de gestión · {{ $grupo }}</p>
            <h1 class="display-5 fw-bold mb-3">Bienvenido al sistema</h1>
            <p class="lead mb-4 text-white-50">Administra la información de clientes y pedidos desde un solo lugar.</p>

            <div class="row g-3">
                <div class="col-md-6">
                    <div class="rounded-3 bg-white bg-opacity-10 p-3 h-100">
                        <div class="small text-white-50 mb-1">Integrantes</div>
                        <div class="fw-semibold">{{ $nombres }}</div>
                        <div class="small text-white-50 mt-1">{{ $apellidos }}</div>
                    </div>
                </div>
                <div class="col-md-6 d-flex align-items-center">
                    @auth
                        <div class="d-flex flex-wrap gap-2">
                            <a href="{{ route('clientes.index') }}" class="btn btn-light text-primary">Ver clientes</a>
                            <a href="{{ route('pedidos.index') }}" class="btn btn-outline-light">Ver pedidos</a>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-light text-primary">Iniciar sesión</a>
                    @endauth
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
