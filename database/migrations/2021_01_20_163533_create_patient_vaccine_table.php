<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientVaccineTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patient_vaccines', function (Blueprint $table) {
            $table->id();
            $table->integer('patient_id');
            $table->string('name',50)->nullable();
            $table->string('vaccine_name',50)->nullable();
            $table->tinyInteger('dose_number')->nullable();
            $table->string('lot_number',15)->nullable();
            $table->string('manufacturer',50)->nullable();
            $table->date('dose_date')->nullable();
            $table->string('health_pro',100)->nullable();
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
        Schema::dropIfExists('patient_vaccine');
    }
}
