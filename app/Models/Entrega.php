<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Entrega extends Model
{
    protected $table = 'entrega';

    protected $primaryKey = 'id_entrega';

    public $timestamps = false;

    protected $fillable = [
        'id_pedido',
        'id_motorista',
        'id_veiculo',
        'id_rota',
        'data_saida',
        'previsao_entrega',
        'data_entrega',
        'status',
    ];

    public function pedido()
    {
        return $this->belongsTo(Pedido::class, 'id_pedido', 'id_pedido');
    }

    public function motorista()
    {
        return $this->belongsTo(Motorista::class, 'id_motorista', 'id_motorista');
    }

    public function veiculo()
    {
        return $this->belongsTo(Veiculo::class, 'id_veiculo', 'id_veiculo');
    }

    public function rota()
    {
        return $this->belongsTo(Rota::class, 'id_rota', 'id_rota');
    }

    public function ocorrencias()
    {
        return $this->hasMany(Ocorrencia::class, 'id_entrega', 'id_entrega');
    }

    public function logs()
    {
        return $this->hasMany(LogStatusEntrega::class, 'id_entrega', 'id_entrega');
    }
}
