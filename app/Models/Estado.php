<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Estado extends Model
{
    use HasFactory;

    protected $fillable = [
        'uf',
        'nome',

    ];


    public function Cidade() {
        return $this->hasMany(Cidade::class);
    }


    public function Paciente() {
        return $this->hasMany(Paciente::class);
    }

}
