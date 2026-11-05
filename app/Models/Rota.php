<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rota extends Model
{
    protected $table = 'rota';

    protected $primaryKey = 'id_rota';

    public $timestamps = false;

    protected $fillable = [
        'cidade_origem',
        'cidade_destino',
        'distancia_km',
        'tempo_estimado',
    ];

    public function entregas()
    {
        return $this->hasMany(Entrega::class, 'id_rota', 'id_rota');
    }
}
