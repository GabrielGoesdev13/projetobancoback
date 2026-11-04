<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Veiculo extends Model
{
    protected $table = 'veiculo';

    protected $primaryKey = 'id_veiculo';

    public $timestamps = false;

    protected $fillable = [
        'placa',
        'modelo',
        'marca',
        'tipo',
        'ano',
        'capacidade_kg',
        'status',
    ];

    public function entregas()
    {
        return $this->hasMany(Entrega::class, 'id_veiculo', 'id_veiculo');
    }
}
