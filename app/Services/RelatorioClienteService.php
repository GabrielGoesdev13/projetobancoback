<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class RelatorioClienteService
{
    public function calcularTotalFretes(int $idCliente): float
    {
        $resultado = DB::selectOne(
            'select calcular_total_fretes_cliente(?) as total_fretes',
            [$idCliente]
        );

        return (float) $resultado->total_fretes;
    }
}
