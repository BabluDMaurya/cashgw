<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIndividualKycsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('individual_kycs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unique();           
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

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('individual_kycs');
    }
}
