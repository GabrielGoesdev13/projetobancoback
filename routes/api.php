<?php

use App\Http\Controllers\Api\EntregaController;
use Illuminate\Support\Facades\Route;

Route::apiResource('entregas', EntregaController::class)
    ->parameters(['entregas' => 'entrega']);

Route::patch('entregas/{entrega}/finalizar', [EntregaController::class, 'finalizar']);
Route::post('entregas/{entrega}/ocorrencias', [EntregaController::class, 'registrarOcorrencia']);
Route::get('entregas/{entrega}/historico', [EntregaController::class, 'historico']);