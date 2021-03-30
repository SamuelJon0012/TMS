<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ProcedureResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('procedure_results', function (Blueprint $table) {
            $table->integer('encounter_id')->index();
            $table->integer('procedure_id')->index();
            $table->integer('patient_id')->index();
            $table->string('result')->index();
            $table->dateTime('datetime')->index();
            $table->dateTime('expiration_datetime')->index();
            $table->dateTime('email_sent_at')->nullable()->index();
            $table->primary(['encounter_id','procedure_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('procedure_results');
    }
}
