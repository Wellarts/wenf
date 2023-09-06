<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exame extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',

    ];

    public function Perinatal() {
        return $this->belongsTo(Perinatal::class);
    }

    public function ExamePerinatal() {
        return $this->hasMany(ExamePerinatal::class);
    }
}
