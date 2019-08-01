<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEstudiantesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estudiantes', function (Blueprint $table) {

            $table->increments('id');
            $table->integer('salon_id')->unsigned();
            $table->string('nombres',250);
            $table->string('dni',14);
            $table->boolean('estado')->default(1);
            $table->timestamps();

            $table->foreign('salon_id')->references('id')->on('salones');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('estudiantes');
    }
}
