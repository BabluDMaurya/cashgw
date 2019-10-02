<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmailOTPChecksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('email_o_t_p_checks')){
        Schema::create('email_o_t_p_checks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('email');
            $table->integer('otp');
            $table->string('token');
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
        Schema::dropIfExists('email_o_t_p_checks');
    }
}
