<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('activities')){
        Schema::create('activities', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id');
            $table->integer('to_user_id');
            $table->string('invoice_id',100)->default(0);
            $table->string('type')->comment('1=sent money,2=Request Money,3=Recived Money, 4=Currency conversion, 5=Sent Invoice, 6=Recived Invoice, 7=Paid Invoice');
            $table->string('name');
            $table->string('email');
            $table->string('status');
            $table->string('balance',1000);
            $table->string('fee',300)->nullable();
            $table->string('description',1000)->nullable();
            $table->string('currency')->comment('1=USD,2=EUR');
            $table->string('transactionid',1000)->nullable();
            $table->string('showdate')->nullable();
            $table->integer('archieve')->default(1)->comment('1=unarchieve,2=archieve');
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
        Schema::dropIfExists('activities');
    }
}
