<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('réservations', function (Blueprint $table) {
    $table->id();
    $table->unsignedBigInteger('médecin_id'); 
    $table->unsignedBigInteger('patients');
    $table->foreign('médecin_id')->references('id')->on('médecins'); 
    $table->foreign('patients')->references('id')->on('patients');
    $table->string('date');
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
        Schema::dropIfExists('réservations');
    }
};
