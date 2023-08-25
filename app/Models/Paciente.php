<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paciente extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'data_nascimento',
        'endereco',
        'estado_id',
        'cidade_id',
        'profissão',
        'telefone',
        'cor',
    ];

    public function Estado() {
        return $this->belongsTo(Estado::class);
    }

    public function Cidade() {
        return $this->belongsTo(Cidade::class);
    }

    public function PlanejamentoReprodutivo() {
        return $this->hasMany(PlanejamentoReprodutivo::class);
    }

}
