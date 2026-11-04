<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class RelatorioMotoristaService
{
    public function contarEntregas(int $idMotorista): int
    {
        $resultado = DB::selectOne(
            'select contar_entregas_motorista(?) as total_entregas',
            [$idMotorista]
        );

        return (int) $resultado->total_entregas;
    }
}
