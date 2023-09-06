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
        Schema::create('perinatals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('paciente_id');
            $table->string('peso');
            $table->string('altura');
            $table->date('dum');
            $table->date('dpp');
            $table->date('dpp_eco');
            $table->string('gravidez_planejada');
            $table->string('parto');
            $table->string('bebe_2500');
            $table->string('bebe_4500');
            $table->string('pre_eclampsia');
            $table->string('gesta');
            $table->string('gesta_ectopia');
            $table->string('abortos');
            $table->string('abortos_3');
            $table->string('parto_vaginal');
            $table->string('cesarea');
            $table->string('cesarea_previa_2');
            $table->string('nascido_vivo');
            $table->string('nascido_vivo_vivem');
            $table->string('nascido_morto');
            $table->string('morto_semana_1');
            $table->string('morto_depois_semana_1');
            $table->string('final_gesta_anterior_1_ano');
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
            $table->string('vacina_influenza');
            $table->string('vacina_vacina_dtpa');
            $table->date('vacina_influenza_data');
            $table->date('vacina_vacina_dtpa_data');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('perinatals');
    }
};
