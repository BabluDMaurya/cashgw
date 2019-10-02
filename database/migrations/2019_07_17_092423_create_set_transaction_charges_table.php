<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSetTransactionChargesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('set_transaction_charges')){
        Schema::create('set_transaction_charges', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id')->unique()->nullable();
            $table->integer('charge_type')->nullable()->comment('1=percent, 2=flat');
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
        Schema::dropIfExists('set_transaction_charges');
    }
}
