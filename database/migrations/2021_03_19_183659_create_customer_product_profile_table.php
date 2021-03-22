<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerProductProfileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_product_profile', function (Blueprint $table) {
            
            $table->id()->unsigned()->comment("Unique identifer for a customer's product definition");
            $table->bigInteger('client_id')->unsigned()->comment("relational element to client_profile.id")->index();
            $table->bigInteger('customer_id')->unsigned()->nullable(false)->comment('relational element to customer_profile.id')->index();
            $table->string('product_name')->nullable(false)->comment("The TrackMy Solutions product name");
            $table->timestamps();
            
        });
        
        Schema::table('customer_product_profile', function(Blueprint $table) {
            $table->foreign('client_id')->references('id')->on('client_profile');
            $table->foreign('customer_id')->references('id')->on('customer_profile');
        });
                
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customer_product_profile');
    }
}
