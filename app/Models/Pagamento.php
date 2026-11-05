<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pagamento extends Model
{
    protected $table = 'pagamento';

    protected $primaryKey = 'id_pagamento';

    public $timestamps = false;

    protected $fillable = [
        'id_pedido',
        'valor',
        'data_pagamento',
        'metodo',
        'status',
    ];

    public function pedido()
    {
        return $this->belongsTo(Pedido::class, 'id_pedido', 'id_pedido');
    }
}
