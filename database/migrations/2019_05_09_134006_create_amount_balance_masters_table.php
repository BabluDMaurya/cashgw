<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAmountBalanceMastersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
     if(!Schema::hasTable('amount_balance_masters')){
        Schema::create('amount_balance_masters', function (Blueprint $table) {
            $table->increments('id');
            
            $table->integer('user_id');
            
            $table->string('balance',300)->nullable();
            $table->string('admin_request')->nullable();
            $table->string('currency_requested')->nullable();
            
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
        Schema::dropIfExists('amount_balance_masters');
    }
}
