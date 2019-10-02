<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUnRegisterEmailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('un_register_emails', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('table');
            $table->integer('row_id');
            $table->integer('user_id');
            $table->string('email');
            $table->string('cname');
            $table->string('cvalue');
            $table->integer('mailcount')->nullable();
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
        Schema::dropIfExists('un_register_emails');
    }
}
