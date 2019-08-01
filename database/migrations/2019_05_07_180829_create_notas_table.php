<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('competencia_id')->unsigned();
            $table->integer('estudiante_id')->unsigned();
            $table->integer('curso_id')->unsigned();
            $table->integer('calificacion');
            $table->string('bimestre',30);

            $table->timestamps();

            $table->foreign('competencia_id')->references('id')->on('competencias');
            $table->foreign('estudiante_id')->references('id')->on('estudiantes');
            $table->foreign('curso_id')->references('id')->on('cursos');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notas');
    }
}
