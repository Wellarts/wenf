<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContasReceber extends Model
{
    use HasFactory;

    protected $fillable = [
        'paciente_id',
        'parcelas',
        'ordem_parcela',
        'formaPgmto',
        'data_vencimento',
        'data_recebimento',
        'status',
        'valor_total',
        'valor_parcela',
        'valor_recebido',
        'obs'
    ];

    public function Paciente()
    {
        return $this->belongsTo(Paciente::class);
    }
}
