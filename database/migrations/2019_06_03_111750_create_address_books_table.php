<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddressBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('address_books', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');    
            $table->string('email')->unique();          
            $table->string('fname'); 
            $table->string('lname'); 
            $table->string('phone'); 
            $table->string('business_name');
            $table->string('country')->nullable();
            $table->string('additional_information',1000)->nullable();
            $table->string('billing_add_country')->nullable();
            $table->string('billing_address_line_one',1000)->nullable();
            $table->string('billing_address_line_two',1000)->nullable();
            $table->string('billing_address_town_city')->nullable();
            $table->string('billing_address_state')->nullable();
            $table->string('billing_address_zipcode')->nullable();
            $table->string('shipping_address_fname')->nullable();
            $table->string('shipping_address_lname')->nullable();
            $table->string('shipping_address_business_name')->nullable();
            $table->string('shipping_address_country')->nullable();
            $table->string('shipping_address_line_one',1000)->nullable();
            $table->string('shipping_address_line_two',1000)->nullable();
            $table->string('shipping_address_town_city')->nullable();
            $table->string('shipping_address_state')->nullable();
            $table->string('shipping_address_zipcode')->nullable();
            $table->text('customer_memo',1000)->nullable();
            $table->integer('status')->default(1);
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
        Schema::dropIfExists('address_books');
    }
}
