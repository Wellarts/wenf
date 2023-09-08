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
        Schema::create('planejamento_ginecologicos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('paciente_id');
            $table->date('data_atendimento');
            $table->string('peso', 100);
            $table->string('altura', 100);
            $table->string('imc', 100);
            $table->string('temp', 100);
            $table->string('pa',100);
            $table->string('spo2',100);
            $table->string('fc',100);
            $table->string('queixa_principal',250);
            $table->longText('historia_doenca',250);
            $table->string('menarca',100);
            $table->date('dum',100);
            $table->string('ciclo_mestrual',100);
            $table->string('smp',100);
            $table->string('metodo_contraceptivo',100);
            $table->string('corrimento',100);
            $table->string('corrimento_desc',200);
            $table->string('gesta',100);
            $table->string('parto',100);
            $table->string('aborto',100);
            $table->string('gravidez_ectopica',100);
            $table->string('intercorrencias',100);
            $table->string('intercorrencias_desc',100);
            $table->date('primeiro_parto',100);
            $table->date('ultimo_parto',100);
            $table->string('aleitamento',100);
            $table->string('medicacao_uso',100);
            $table->string('medicacao_uso_desc',100);
            $table->string('tabagismo',100);
            $table->string('etilismo',100);
            $table->string('drogas',100);
            $table->string('sintomas_urinario',100);
            $table->string('sintomas_urinario_desc',200);
            $table->string('sintomas_intestinais',100);
            $table->string('sintomas_intestinais_desc',200);
            $table->string('cardiovasculares',100);
            $table->string('cardiovasculares_desc',200);
            $table->string('cardiovasculares_f',100);
            $table->string('cardiovasculares_f_desc',200);
            $table->string('endocrinas',100);
            $table->string('endocrinas_desc',200);
            $table->string('endocrinas_f',100);
            $table->string('endocrinas_f_desc',200);
            $table->string('alergias',100);
            $table->string('alergias_desc',200);
            $table->string('vacina_dt',100);
            $table->date('vacina_dt_data_1',100);
            $table->date('vacina_dt_data_2',100);
            $table->date('vacina_dt_data_3',100);
            $table->date('vacina_dt_reforco',100);
            $table->string('vacina_hpv',100);
            $table->string('vacina_hpv_data_1',100);
            $table->string('vacina_hpv_data_2',100);
            $table->string('vacina_hepatite_b',100);
            $table->date('vacina_hepatite_b_data_1',100);
            $table->date('vacina_hepatite_b_data_2',100);
            $table->date('vacina_hepatite_b_data_3',100);
            $table->string('ist_s',100);
            $table->string('ist_s_desc',100);
            $table->string('cirurgias_transfusao',100);
            $table->string('cirurgias_transfusao_desc',200);
            $table->string('cancer',100);
            $table->string('cancer_desc',200);
            $table->string('cancer_f',100);
            $table->string('cancer_f_desc',200);
            $table->string('outros',100);
            $table->string('outros_desc',200);
            $table->string('outros_f',100);
            $table->string('outros_f_desc',200);
            $table->string('insp_estatica',100);
            $table->string('insp_dinamica',100);
            $table->string('palpacao',100);
            $table->string('descarga_papilar',100);
            $table->string('descarga_papilar_desc',200);
            $table->string('anexo_1',100);
            $table->string('vulva',100);
            $table->string('vulva_desc',200);
            $table->string('vagina',100);
            $table->string('colo',100);
            $table->string('muco',100);
            $table->string('anexo_2',200);
            $table->string('diagnostico_intervencao_id',100);
            $table->string('planejamento_implementacao_id',100);
            $table->longText('planejamento_desc',200);
            $table->longText('avaliacao',200);
            $table->string('anexo_exame',200);
            $table->string('anexo_outros',200);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('planejamento_ginecologicos');
    }
};
