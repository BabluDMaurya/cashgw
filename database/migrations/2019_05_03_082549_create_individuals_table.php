<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIndividualsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('individuals', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unique();            
            $table->integer('verify')->default(0);
            $table->integer('kyc')->default(0);
            $table->integer('kyc_verify')->default(0);
            $table->integer('admin_verify')->default(0);
            $table->integer('account_status')->default(1);
            
            $table->string('lang')->nullable();
            $table->string('primary_email')->nullable();
            $table->string('secondary_email')->nullable();
            $table->string('primary_phone')->nullable();
            $table->string('secondary_phone')->nullable();
            $table->string('primary_currency')->nullable();
            
            $table->string('billing_address_line_one',1000)->nullable();
            $table->string('billing_address_line_two',1000)->nullable();
            $table->string('billing_address_townOrcity')->nullable();
            $table->string('billing_address_zipcode')->nullable();
            $table->string('billing_address_state')->nullable();
            $table->string('billing_address_country')->nullable();            
            
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
        Schema::dropIfExists('individuals');
    }
}
