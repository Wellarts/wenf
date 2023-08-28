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
        'corrimento_desc',
        'gesta',
        'parto',
        'aborto',
        'gravidez_ectopica',
        'gravidez_ectopica_desc',
        'intercorrencias',
        'primeiro_parto',
        'ultimo_parto',
        'aleitamento',
        'medicacao_uso',
        'medicacao_uso_desc',
        'tabagistmo',
        'etilismo',
        'drogas',
        'sintomas_urinario',
        'sintomas_urinario_desc',
        'sintomas_intestinais',
        'sintomas_intestinais_desc',
        'cardiovasculares',
        'cardiovasculares_desc',
        'endocrinas',
        'endocrinas_desc',
        'alergias',
        'alergias_desc',
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
        'ist_s',
        'ist_s_desc',
        'cirurgias_transfusao',
        'cirurgias_transfusao_desc',
        'cancer',
        'cancer_desc',
        'outros',
        'outros_desc',
        'insp_estatica',
        'insp_dinamica',
        'palpacao',
        'desgarga_papilar',
        'descarga_papilar_desc',
        'anexo_1',
        'vulva',
        'vulva_desc',
        'vagina',
        'colo',
        'muco',
        'anexo_2',
        'diagnostico',
        'diagnostico_cod',
        'planejamento',
        'planejamento_cod',
        'planejamento_desc',
        'avaliacao',
    ];

    public function Paciente()
    {
        return $this->belongsTo(Paciente::class);
    }

    public function DiagnosticoIntervencao() {
        return $this->belongsTo(DiagnosticoIntervencao::class);
    }
}
