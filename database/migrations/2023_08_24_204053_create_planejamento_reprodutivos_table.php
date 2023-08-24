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
            $table->longText('historia_doença');
            $table->string('menarca');
            $table->string('dum');
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
