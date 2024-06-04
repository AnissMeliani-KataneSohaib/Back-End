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
        Schema::create('opérations', function (Blueprint $table) {
    $table->id();
    $table->unsignedBigInteger('medecin_id');
    $table->unsignedBigInteger('patient_id');
    $table->foreign('medecin_id')->references('id')->on('médecins');
    $table->foreign('patient_id')->references('id')->on('patients');
    $table->string('date');
    $table->integer("salle d'opération");;
 
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
        Schema::table('operations', function (Blueprint $table) {
            $table->unsignedBigInteger('médecin_id')->change();
            $table->unsignedBigInteger('patient_id')->change();
        });
        Schema::dropIfExists('opérations');
    }
};
