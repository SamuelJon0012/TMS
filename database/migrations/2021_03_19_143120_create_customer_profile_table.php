<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerProfileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_profile', function (Blueprint $table) {
            
            $table->id()->unsigned()->comment("Unique identifer for a client_profile's customer");
            $table->bigInteger('client_id')->unsigned()->comment("relational element to client_profile.id");
            $table->string('legal_name')->nullable(false)->comment('The legal name of the Trackmy Solutions client')->index();
            $table->string('location')->nullable(false)->comment("generic location of client_profile's customer");
            $table->string('address1')->comment('Address Line 1 of the client');
            $table->string('address2')->comment('Address Line 2 of the client');
            $table->string('city')->comment("client_profile's customer city");
            $table->string('state')->comment("client_profile's customer state");
            $table->string('zipcode')->comment("client_profile's customer zipcode");
            $table->string('primary_contact')->nullable(false)->comment("Name of primary contact at client_profile's customer");
            $table->string('primary_email')->nullable(false)->comment("Primary client_profile's customer contact email address");
            $table->string('primary_phone')->nullable(false)->comment("Primary client_profile's customer contact phone number");
            $table->string('private_id')->comment("Burst IQ's private id for this client's customer's data access");
            $table->timestamps();
 
        });
        
        Schema::table('customer_profile', function(Blueprint $table) {
            $table->foreign('client_id')->references('id')->on('client_profile');
        });
                
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customer_profile');
    }
}
