<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAulasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aulas', function (Blueprint $table) {
            $table->id();
            $table->string('cad_disciplina');
            $table->string('cad_curso');
            $table->string('cad_periodo');
            $table->integer('cad_num_sala');
            $table->string('cad_bloco');
            $table->dateTime('cad_data_hora_inicio');
            $table->dateTime('cad_data_hora_fim');
            $table->integer('cad_tempo_minimo');
            $table->integer('cad_tempo_tolerancia');
            $table->integer('id_professor');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('aulas');
    }
}
