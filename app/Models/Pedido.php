<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    protected $table = 'pedido';

    protected $primaryKey = 'id_pedido';

    public $timestamps = false;

    protected $fillable = [
        'id_cliente',
        'data_pedido',
        'valor_frete',
        'peso_kg',
        'tipo_carga',
        'prioridade',
        'status',
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'id_cliente', 'id_cliente');
    }

    public function pagamentos()
    {
        return $this->hasMany(Pagamento::class, 'id_pedido', 'id_pedido');
    }

    public function entregas()
    {
        return $this->hasMany(Entrega::class, 'id_pedido', 'id_pedido');
    }
}
