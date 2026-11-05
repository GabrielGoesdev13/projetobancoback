<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Entrega extends Model
{
    protected $table = 'entrega';
    protected $primaryKey = 'id_entrega';
    public $timestamps = false;

    protected $fillable = [
        'id_pedido', 'id_motorista', 'id_veiculo', 'id_rota',
        'data_saida', 'previsao_entrega', 'data_entrega', 'status',
    ];
}