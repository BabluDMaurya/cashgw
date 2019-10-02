<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequestForMoneyToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('request_for_money_to_users')){
        Schema::create('request_for_money_to_users', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('from');
            $table->integer('user_id');           
            $table->string('transaction_id',1000)->nullable();
            $table->string('balance_to',1000)->nullable();
            $table->string('balance',1000)->nullable();
            $table->string('currency_requested')->nullable();
            $table->integer('action',11)->default(1)->comment('1=pending,2=completed,3=rejected,4=Unregister User');
            $table->integer('status',11)->default(1)->comment('1=balanceNotAdded, 2=balanceAdded');
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
        Schema::dropIfExists('request_for_money_to_users');
    }
}
