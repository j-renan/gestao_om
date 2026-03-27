<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'tecnico_id',
        'solicitante',
        'ni',
        'tipo_manutencao',
        'prioridade',
        'gestor_responsavel',
        'prazo',
        'status',
    ];

    public function tecnico()
    {
        return $this->belongsTo(User::class, 'tecnico_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
