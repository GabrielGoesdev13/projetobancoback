<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Motorista extends Model
{
    protected $table = 'motorista';

    protected $primaryKey = 'id_motorista';

    public $timestamps = false;

    protected $fillable = [
        'nome',
        'cpf',
        'cnh',
        'categoria_cnh',
        'data_admissao',
        'status',
    ];

    public function entregas()
    {
        return $this->hasMany(Entrega::class, 'id_motorista', 'id_motorista');
    }
}
