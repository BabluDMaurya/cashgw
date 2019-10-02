<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBusinessKycsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('business_kycs')){
        Schema::create('business_kycs', function (Blueprint $table) {
            $table->increments('id');
            
            $table->integer('user_id')->unique();
            
            $table->string('business_name');
            $table->string('business_type');
            $table->string('business_certificate');
            $table->string('business_memorandum');
            
//            $table->string('business_fname')->nullable();
//            $table->string('business_lname')->nullable();
//            $table->string('business_address')->nullable();
//            $table->string('business_phone')->nullable();
//            $table->string('business_fax')->nullable();
//            $table->string('business_email')->nullable();
//            $table->string('business_website')->nullable();
//            $table->string('business_taxid')->nullable();
//            $table->string('business_additional_info')->nullable();
            
            $table->string('fname');
            $table->string('mname');
            $table->string('lname');
            $table->string('dob');
            $table->string('passport_no');
            $table->string('passport_country');
            $table->string('passport_expdate');
            $table->string('passport');
            
            $table->string('add_line_one',1000);
            $table->string('add_line_two',1000);
            $table->string('town_or_city');
            $table->string('zip');
            $table->string('state');
            $table->string('country');
            $table->string('address_proof');
            
            $table->string('photo');
            
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
        Schema::dropIfExists('business_kycs');
    }
}
