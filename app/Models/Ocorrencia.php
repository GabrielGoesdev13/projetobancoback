<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ocorrencia extends Model
{
    protected $table = 'ocorrencia';

    protected $primaryKey = 'id_ocorrencia';

    public $timestamps = false;

    protected $fillable = [
        'id_entrega',
        'tipo',
        'descricao',
        'data_ocorrencia',
        'gravidade',
        'resolvida',
    ];

    protected $casts = [
        'resolvida' => 'boolean',
    ];

    public function entrega()
    {
        return $this->belongsTo(Entrega::class, 'id_entrega', 'id_entrega');
    }
}
