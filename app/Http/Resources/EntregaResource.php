<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EntregaResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'               => $this->id_entrega,
            'id_pedido'        => $this->id_pedido,
            'id_motorista'     => $this->id_motorista,
            'id_veiculo'       => $this->id_veiculo,
            'id_rota'          => $this->id_rota,
            'data_saida'       => $this->data_saida,
            'previsao_entrega' => $this->previsao_entrega,
            'data_entrega'     => $this->data_entrega,
            'status'           => $this->status,
        ];
    }
}