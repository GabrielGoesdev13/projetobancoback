<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogStatusEntrega extends Model
{
    protected $table = 'log_status_entrega';

    protected $primaryKey = 'id_log';

    public $timestamps = false;

    protected $fillable = [
        'id_entrega',
        'status_antigo',
        'status_novo',
        'data_alteracao',
    ];

    public function entrega()
    {
        return $this->belongsTo(Entrega::class, 'id_entrega', 'id_entrega');
    }
}
