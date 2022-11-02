<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIntervencaoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('intervencao', function (Blueprint $table) {
            $table->id();
            $table->string('cad_aluno');
            $table->string('cad_disciplina');
            $table->string('cad_curso');
            $table->string('cad_data');
            $table->string('cad_professor');
            $table->string('cad_motivo');
            $table->boolean('cad_aprovado')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('exemplo_models');
    }
}
