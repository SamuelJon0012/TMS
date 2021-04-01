<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_profile', function (Blueprint $table) {
            $table->id()->unsigned()->comment('Unique identifer for a Trackmy Solutions client');
            $table->string('legal_name')->nullable(false)->comment('The legal name of the Trackmy Solutions client');
            $table->string('address1')->nullable(false)->comment('Address Line 1 of the client');
            $table->string('address2')->nullable(false)->comment('Address Line 2 of the client');
            $table->string('city')->nullable(false)->comment('client city');
            $table->string('state')->nullable(false)->comment('client state');
            $table->string('zipcode')->nullable(false)->comment('client zipcode');
            $table->string('primary_contact')->nullable(false)->comment('Name of primary contact at client');
            $table->string('primary_email')->nullable(false)->comment("Primary contact's email address");
            $table->string('primary_phone')->nullable(false)->comment("Primary contact's phone number");
            $table->string('private_id')->nullable(false)->comment("burst IQ private id for this client's data access");
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
        Schema::dropIfExists('client_profiles');
    }
}
