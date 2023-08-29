<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanejamentoImplementacao extends Model
{
    use HasFactory;

    protected $fillable = [
        'descricao',
         'tipo',
     ];

     public function PlanejamentoGinecologico() {
        $this->hasMany(PlanejamentoGinecologico::class);
    }
}
