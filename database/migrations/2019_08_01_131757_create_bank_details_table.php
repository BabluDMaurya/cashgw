<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBankDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('bank_details')){
        Schema::create('bank_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('bank')->nullable();
            $table->string('bankcode')->nullable();
            $table->string('ifsc')->nullable();
            $table->string('branch')->nullable();
            $table->string('name')->nullable();
            $table->string('address')->nullable();
            $table->string('acno')->nullable();
            $table->string('currency')->nullable();
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
        Schema::dropIfExists('bank_details');
    }
}
