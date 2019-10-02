<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConvertionChargesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('convertion_charges')){
        Schema::create('convertion_charges', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->float('charge',8,2);
            $table->integer('transaction_type')->nullable()->default(0)->comment('1=Send Money, 2=Invoice Pay, 3=Currency Converter');
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
        Schema::dropIfExists('convertion_charges');
    }
}
