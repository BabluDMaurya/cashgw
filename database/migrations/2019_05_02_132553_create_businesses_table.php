<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBusinessesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('businesses')){
        Schema::create('businesses', function (Blueprint $table) {
            $table->increments('id');
            
            $table->integer('user_id')->unique();
            
            $table->string('verify')->default(0);
            $table->string('kyc')->default(0);
            $table->string('kyc_verify')->default(0);
            $table->string('admin_verify')->default(0);
            $table->string('account_status')->default(1);
            
            $table->string('lang')->nullable();
            $table->string('primary_email')->nullable();
            $table->string('secondary_email')->nullable();
            $table->string('primary_phone')->nullable();
            $table->string('secondary_phone')->nullable();
            $table->string('primary_currency')->nullable();
            
            $table->string('business_fname')->nullable();
            $table->string('business_lname')->nullable();
            $table->string('business_address')->nullable();
            $table->string('business_phone')->nullable();
            $table->string('business_fax')->nullable();
            $table->string('business_email')->nullable();
            $table->string('business_website')->nullable();
            $table->string('business_taxid')->nullable();
            $table->string('business_additional_info')->nullable();
            
            $table->string('billing_address_line_one',1000)->nullable();
            $table->string('billing_address_line_two',1000)->nullable();
            $table->string('billing_address_townOrcity')->nullable();
            $table->string('billing_address_zipcode')->nullable();
            $table->string('billing_address_state')->nullable();
            $table->string('billing_address_country')->nullable();
            
            $table->string('shiping_address_line_one',1000)->nullable();
            $table->string('shiping_address_line_two',1000)->nullable();
            $table->string('shiping_address_townOrcity')->nullable();
            $table->string('shiping_address_zipcode')->nullable();
            $table->string('shiping_address_state')->nullable();
            $table->string('shiping_address_country')->nullable();            
            
//            $table->string('address_line_one')->nullable();
//            $table->string('address_line_two')->nullable();
//            $table->string('address_townOrcity')->nullable();
//            $table->string('address_zipcode')->nullable();
//            $table->string('address_state')->nullable();
//            $table->string('address_country')->nullable();
            
            $table->timestamps();
        });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('businesses');
    }
}
