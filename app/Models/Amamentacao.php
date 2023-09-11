<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Amamentacao extends Model
{
    use HasFactory;

    protected $fillable = [
        'paciente_id',
        'data_consulta_gestacao',
        'historico_amamentacao',
        'principais_duvidas',
        'data_consulta_pos_parto',
        'hora_inicio',
        'hora_termino',
        'pre_natal',
        'hemorragia_pos_parto',
        'medicacao_uso',
        'medicacao_uso_desc',
        'rede_apoio',
        'tipo_mamilo',
        'tipo_parto',
        'historico_doenças',
        'historico_doenças_desc',
        'cirurgias_mamarias',
        'cirurgias_mamarias_desc',
        'tipo_mamas',
        'aparencias_mamas',
        'saida_leite',
        'obs',
        'alteracoes_mamarias',
        'obs_mamarias',
        'avaliacao_dor',
        'intesidade_dor',
        'ig',
        'sexo',
        'apgar_1_mim',
        'apgar_5_mim',
        'peso_nasc',
        'peso_atual',
        'padrao_motor',
        'conciencia',
        'refluxo',
        'refluxo_vezes',
        'diurese',
        'diurese_qtd_fraldas',
        'evacuacoes',
        'evacuacoes_color',
        'reflexos',
        'reflexos_desc',
        'padrao_succao',
        'uso_bicos',
        'uso_desc',
        'formula_infaltil',
        'formula_infaltil_desc',
        'anexo_mamas',
        'diagnostico_intervencao_id',
        'planejamento_implementacao_id',
        'planejamento_desc',
        'avaliacao',
        'anexo_outros',
        'status',
    ];

    protected $casts = [
        'diagnostico_intervencao_id' => 'array',
        'planejamento_implementacao_id' => 'array',
        'anexo_outros' => 'array',
        'alteracoes_mamarias' => 'array',
        'avaliacao_dor' => 'array',

    ];

    public function Paciente()
    {
        return $this->belongsTo(Paciente::class);
    }
}
