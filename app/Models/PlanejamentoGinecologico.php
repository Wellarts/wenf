<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanejamentoGinecologico extends Model
{
    use HasFactory;

    protected $fillable = [

        'paciente_id',
        'data_atendimento',
        'peso',
        'altura',
        'imc',
        'temp',
        'pa',
        'spo2',
        'fc',
        'queixa_principal',
        'historia_doenca',
        'menarca',
        'dum',
        'ciclo_mestrual',
        'smp',
        'metodo_contraceptivo',
        'corrimento',
        'gesta',
        'parto',
        'aborto',
        'gravidez_ectopica',
        'intercorrencias',
        'primeiro_parto',
        'ultimo_parto',
        'aleitamento',
        'medicacao_uso',
        'tabagistmo',
        'etilismo',
        'drogas',
        'sintomas_urinario',
        'sintomas_intestinais',
        'cardiovasculares',
        'endocrinas',
        'alergias',
        'vacinacao',
        'ist_s',
        'cirurgias_transfusao',
        'cancer',
        'outros',
        'insp_estatica',
        'insp_dinamica',
        'palpacao',
        'desgarga_papilar',
        'vulva',
        'vagina',
        'colo',
        'muco',
        'diagnostico',
        'planejamento',
        'avaliacao',
    ];

    public function Paciente()
    {
        return $this->belongsTo(Paciente::class);
    }
}
