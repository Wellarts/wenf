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
        Schema::create('planejamento_reprodutivos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('paciente_id');
            $table->date('data_atendimento');
            $table->string('peso');
            $table->string('altura');
            $table->string('imc');
            $table->string('temp');
            $table->string('pa');
            $table->string('spo2');
            $table->string('fc');
            $table->string('queixa_principal');
            $table->longText('historia_doenca');
            $table->string('menarca');
            $table->date('dum');
            $table->string('ciclo_mestrual');
            $table->string('smp');
            $table->string('metodo_contraceptivo');
            $table->string('corrimento');
            $table->string('corrimento_desc');
            $table->string('dispareunia');
            $table->string('gesta');
            $table->string('parto');
            $table->string('aborto');
            $table->string('gravidez_ectopica');
            $table->string('intercorrencias');
            $table->string('intercorrencias_desc');
            $table->date('primeiro_parto');
            $table->date('ultimo_parto');
            $table->string('aleitamento');
            $table->text('medicacao_uso', 100);
            $table->string('medicacao_uso_desc');
            $table->string('tabagismo');
            $table->string('etilismo');
            $table->string('drogas');
            $table->string('sintomas_urinario');
            $table->string('sintomas_urinario_desc');
            $table->string('sintomas_intestinais');
            $table->string('sintomas_intestinais_desc');
            $table->string('cardiovasculares');
            $table->string('cardiovasculares_desc');
            $table->string('cardiovasculares_f');
            $table->string('cardiovasculares_f_desc');
            $table->string('endocrinas');
            $table->string('endocrinas_desc');
            $table->string('endocrinas_f');
            $table->string('endocrinas_f_desc');
            $table->string('alergias');
            $table->string('alergias_desc');
            $table->string('vacina_dt');
            $table->date('vacina_dt_data_1');
            $table->date('vacina_dt_data_2');
            $table->date('vacina_dt_data_3');
            $table->date('vacina_dt_reforco');
            $table->string('vacina_hpv');
            $table->string('vacina_hpv_data_1');
            $table->string('vacina_hpv_data_2');
            $table->string('vacina_hepatite_b');
            $table->date('vacina_hepatite_b_data_1');
            $table->date('vacina_hepatite_b_data_2');
            $table->date('vacina_hepatite_b_data_3');
            $table->string('ist_s');
            $table->string('ist_s_desc');
            $table->string('cirurgias_transfusao');
            $table->string('cirurgias_transfusao_desc');
            $table->string('cancer');
            $table->string('cancer_desc');
            $table->string('cancer_f');
            $table->string('cancer_f_desc');
            $table->string('outros');
            $table->string('outros_desc');
            $table->string('outros_f');
            $table->string('outros_f_desc');
            $table->string('mamografia');
            $table->string('preventivo');
            $table->date('data_mamografia');
            $table->date('data_preventivo');
            $table->string('diagnostico_intervencao_id');
            $table->string('planejamento_implementacao_id');
            $table->longText('planejamento_desc');
            $table->longText('avaliacao');
            $table->string('anexo_termo');
            $table->string('anexo_outros');
            $table->string('status',10);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('planejamento_reprodutivos');
    }
};
