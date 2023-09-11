<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('amamentacaos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('paciente_id');
            $table->date('data_consulta_gestacao');
            $table->string('historico_amamentacao');
            $table->string('principais_duvidas');
            $table->date('data_consulta_pos_parto');
            $table->string('hora_inicio',50);
            $table->string('hora_termino',50);
            $table->string('pre_natal',50);
            $table->string('hemorragia_pos_parto',50);
            $table->string('medicacao_uso',50);
            $table->string('medicacao_uso_desc');
            $table->string('rede_apoio',50);
            $table->string('tipo_mamilo',50);
            $table->string('tipo_parto',50);
            $table->string('historico_doenças',50);
            $table->string('historico_doenças_desc');
            $table->string('cirurgias_mamarias',50);
            $table->string('cirurgias_mamarias_desc');
            $table->string('tipo_mamas',50);
            $table->string('aparencias_mamas',50);
            $table->string('saida_leite',50);
            $table->longText('obs');
            $table->string('alteracoes_mamarias',50);
            $table->string('avaliacao_dor',50);
            $table->string('intesidade_dor',50);
            $table->string('ig',50);
            $table->string('sexo',50);
            $table->string('apgar_1_mim',50);
            $table->string('apgar_5_mim',50);
            $table->string('peso_nasc',50);
            $table->string('peso_atual',50);
            $table->string('padrao_motor',50);
            $table->string('conciencia',50);
            $table->string('refluxo',50);
            $table->string('refluxo_vezes',50);
            $table->string('diurese_qtd_fraldas',50);
            $table->string('evacuacoes',50);
            $table->string('evacuacoes_color',50);
            $table->string('reflexos',50);
            $table->string('reflexos_desc',50);
            $table->string('padrao_succao',50);
            $table->string('uso_bicos',50);
            $table->string('uso_desc');
            $table->string('formula_infaltil',50);
            $table->string('formula_infaltil_desc');
            $table->string('alteracao_lingua', 50);
            $table->string('anexo_mamas');
            $table->string('diagnostico_intervencao_id',100);
            $table->string('planejamento_implementacao_id',100);
            $table->longText('planejamento_desc',200);
            $table->longText('avaliacao',200);
            $table->string('anexo_outros',200);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('amamentacaos');
    }
};
