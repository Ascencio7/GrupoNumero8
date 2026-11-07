<?php

use App\Http\Controllers\ClienteController;
use App\Http\Controllers\PedidoController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home', [
        'nombres' => 'Emir Alexander, Jonathan Vladimir, Ruth Abigail',
        'apellidos' => 'Alvarado Velasco, Ascencio Ramos, Vaquerano Melara',
        'grupo' => 'Grupo 8, IDSN421',
    ]);
});

Auth::routes();

Route::get('/home', function () {
    return redirect('/');
})->middleware('auth')->name('home');

Route::middleware(['auth'])->group(function () {
    Route::resource('clientes', ClienteController::class);
    Route::resource('pedidos', PedidoController::class);

    Route::get('/reportes/pedidos', [PedidoController::class, 'reporteTodos'])->name('reportes.pedidos');
    Route::get('/reportes/clientes', [ClienteController::class, 'reporteTodos'])->name('reportes.clientes');
    Route::get('/reportes/pedidos-por-cliente', [PedidoController::class, 'reportePorCliente'])->name('reportes.por_cliente');

    Route::get('/reportes/clientes/pdf', [ClienteController::class, 'reportePdf'])->name('reportes.clientes.pdf');
    Route::get('/reportes/pedidos/pdf', [PedidoController::class, 'reportePdf'])->name('reportes.pedidos.pdf');
    Route::get('/reportes/pedidos-por-cliente/pdf', [PedidoController::class, 'reportePorClientePdf'])->name('reportes.por_cliente.pdf');
});
