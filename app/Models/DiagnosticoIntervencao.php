<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiagnosticoIntervencao extends Model
{
    use HasFactory;

    protected $fillable = [
        'codigo',
        'descricao',
        'tipo',
    ];

    public function PlanejamentoGinecologico() {
        $this->hasMany(PlanejamentoGinecologico::class);
    }
}
