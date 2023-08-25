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
            $table->string('gesta');
            $table->string('parto');
            $table->string('aborto');
            $table->string('gravidez_ectopica');
            $table->string('intercorrencias');
            $table->date('primeiro_parto');
            $table->date('ultimo_parto');
            $table->string('aleitamento');
            $table->string('medicacao_uso');
            $table->string('tabagistmo');
            $table->string('etilismo');
            $table->string('drogas');
            $table->string('sintomas_urinario');
            $table->string('sintomas_intestinais');
            $table->string('cardiovasculares');
            $table->string('endocrinas');
            $table->string('alergias');
            $table->string('vacinacao');
            $table->string('ist_s');
            $table->string('cirurgias_transfusao');
            $table->string('cancer');
            $table->string('outros');
            $table->string('mamografia');
            $table->string('preventivo');
            $table->date('data_mamografia');
            $table->date('data_preventivo');
            $table->longText('diagnostico');
            $table->longText('planejamento');
            $table->longText('avaliacao');
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
