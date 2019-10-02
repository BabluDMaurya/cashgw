<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCashgwChargesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('cashgw_charges')){
        Schema::create('cashgw_charges', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->float('charge',8,2);
            $table->integer('minval');
            $table->integer('maxval');
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
        Schema::dropIfExists('cashgw_charges');
    }
}
