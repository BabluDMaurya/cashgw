<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCurrencyConvertionTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('currency_convertion_transactions')){
        Schema::create('currency_convertion_transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('transactionId');
            $table->integer('user_id');
            $table->string('fromCurrency');
            $table->string('toCurrency');
            $table->string('rate');
            $table->string('amount');
            $table->string('convertedAmount');
            $table->string('canvertionCharge')->nullable();
            $table->string('cashgwCharge')->nullable();
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
        Schema::dropIfExists('currency_convertion_transactions');
    }
}
