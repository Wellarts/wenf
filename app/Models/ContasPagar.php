<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContasPagar extends Model
{
    use HasFactory;

    protected $fillable = [
        'fornecedor_id',
        'parcelas',
        'ordem_parcela',
        'formaPgmto',
        'data_vencimento',
        'data_pagamento',
        'status',
        'valor_total',
        'valor_parcela',
        'valor_pago',
        'obs'
    ];

    public function fornecedor()
    {
        return $this->belongsTo(Fornecedor::class);
    }
}
