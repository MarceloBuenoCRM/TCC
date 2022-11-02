<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('cad_nome');
            $table->string('cad_email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('cad_senha');
            $table->tinyInteger('cad_modo_escuro')->default('0');
            $table->tinyInteger('tipo_usuario')->default('0');
            $table->string('cad_token_api')->default('');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
