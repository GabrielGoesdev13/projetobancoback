<?php

use App\Http\Controllers\ClienteController;
use App\Http\Controllers\PedidoController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('clientes.index');
});

Route::resource('clientes', ClienteController::class);
Route::resource('pedidos', PedidoController::class);