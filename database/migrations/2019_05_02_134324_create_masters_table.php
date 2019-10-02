<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMastersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('masters')){
        Schema::create('masters', function (Blueprint $table) {
            $table->increments('id');
            
            $table->integer('user_id')->unique();
            
            //business records start
            //business table
            $table->integer('verify')->default(0);;
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
            
            $table->string('shiping_address_line_one',1000)->nullable();
            $table->string('shiping_address_line_two',1000)->nullable();
            $table->string('shiping_address_townOrcity')->nullable();
            $table->string('shiping_address_zipcode')->nullable();
            $table->string('shiping_address_state')->nullable();
            $table->string('shiping_address_country')->nullable();
            
            $table->string('business_fname')->nullable();
            $table->string('business_lname')->nullable();
            $table->string('business_address')->nullable();
            $table->string('business_phone')->nullable();
            $table->string('business_fax')->nullable();
            $table->string('business_email')->nullable();
            $table->string('business_website')->nullable();
            $table->string('business_taxid')->nullable();
            $table->string('business_additional_info')->nullable();
            
            //business kyc start
            $table->string('business_name')->nullable();
            $table->string('business_type')->nullable();
            $table->string('business_certificate')->nullable();
            $table->string('business_memorandum')->nullable();
            
            
            $table->string('fname');
            $table->string('mname');
            $table->string('lname');
            $table->string('dob');
            $table->string('passport_no');
            $table->string('passport_country');
            $table->string('passport_expdate');
            $table->string('passport');
            
            $table->string('add_line_one');
            $table->string('add_line_two');
            $table->string('town_or_city');
            $table->string('zip');
            $table->string('state');
            $table->string('country');
            $table->string('address_proof');
            
            $table->string('photo');
            //business kyc end
            //business records ends
            
            //amount balance master
            $table->string('usd_balance',500)->nullable();
            $table->string('euro_balance',500)->nullable();
            //amount balance master end
            
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
        Schema::dropIfExists('masters');
    }
}
