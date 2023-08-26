<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Receituario extends Model
{
    use HasFactory;

    protected $fillable = [
        'paciente_id',
        'data_receituario',
        'descricao',

    ];

    public function Paciente()
    {
        return $this->belongsTo(Paciente::class);
    }
}
