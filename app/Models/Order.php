<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'solicitante',
        'ni',
        'tipo_manutencao',
        'prioridade',
        'gestor_responsavel',
        'prazo',
        'status',
    ];
}
