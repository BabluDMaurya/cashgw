<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBusinessDebitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('business_debits')){
            Schema::create('business_debits', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->integer('user_id')->index();
                $table->string('transactionid');
                $table->string('name')->nullable();
                $table->string('amount',300)->nullable();
                $table->string('email')->nullable();
                $table->string('details',1000)->nullable();
                $table->string('status')->nullable()->default(0)->comment('0=pending, 1=complete, 2=reject');
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
        Schema::dropIfExists('business_debits');
    }
}
