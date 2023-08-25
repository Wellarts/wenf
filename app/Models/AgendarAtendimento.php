<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgendarAtendimento extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'data_atendimento',
        'hora_atendimento',
        'descricao',
        'status',
    ];
}
