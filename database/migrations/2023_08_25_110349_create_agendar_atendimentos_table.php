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
        Schema::create('agendar_atendimentos', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->date('data_atendimento');
            $table->string('hora_atendimento');
            $table->longText('descricao');
            $table->boolean('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agendar_atendimentos');
    }
};
