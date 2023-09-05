<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perinatal extends Model
{
    use HasFactory;

    protected $fillable = [
        'paciente_id',
           'peso',
           'altura',
           'dum',
           'dpp',
           'dpp_eco',
           'gravidez_planejada',
           'parto',
           'bebe_2500',
           'bebe_4500',
           'pre_eclampsia',
           'gesta_previa',
           'gesta_previa_ectopia',
           'abortos',
           'abortos_3',
           'parto_vaginal',
           'cesarea',
           'cesarea_previa_2',
           'nascido_vivo',
           'nascido_vivo_vivem',
           'nascido_morto',
           'morto_semana_1',
           'morto_depois_semana_1',
           'final_gesta_anterior_1_ano',
           'vacina_dt',
           'vacina_dt_data_1',
           'vacina_dt_data_2',
           'vacina_dt_data_3',
           'vacina_dt_reforco',
           'vacina_hpv',
           'vacina_hpv_data_1',
           'vacina_hpv_data_2',
           'vacina_hepatite_b',
           'vacina_hepatite_b_data_1',
           'vacina_hepatite_b_data_2',
           'vacina_hepatite_b_data_3',
    ];

    public function Paciente()
    {
        return $this->belongsTo(Paciente::class);
    }
}
