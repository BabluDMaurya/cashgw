<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecivedMoneyFromUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('recived_money_from_users')){
        Schema::create('recived_money_from_users', function (Blueprint $table) {
            $table->increments('id');            
            $table->integer('user_id');           
            $table->integer('to');
            $table->string('balance',300)->nullable();
            $table->string('currency_requested')->nullable();
            $table->string('note',1000)->nullable();
            $table->integer('action')->comment('1=pending,2=completed,3=rejected');
            $table->integer('status')->comment('1=balanceNotAdded, 2=balanceAdded');
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
        Schema::dropIfExists('recived_money_from_users');
    }
}
