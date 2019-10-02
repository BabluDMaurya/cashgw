<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequestForMoneyToAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('request_for_money_to_admins')){
        Schema::create('request_for_money_to_admins', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');            
            $table->string('balance')->nullable();
            $table->string('currency_requested')->nullable();
            $table->integer('admin_action',11)->default(1)->comment('1=pending,2=completed,3=rejected');
            $table->integer('status',11)->default(1)->comment('1=balanceNotAdded, 2=balanceAdded');
            $table->string('bankid')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('refcode')->nullable();
            $table->srting('transaction_id',1000)->nullable();
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
        Schema::dropIfExists('request_for_money_to_admins');
    }
}
