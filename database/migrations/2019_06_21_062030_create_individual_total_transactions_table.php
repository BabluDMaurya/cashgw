<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIndividualTotalTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('individual_total_transactions')){
        Schema::create('individual_total_transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
                $table->integer('user_id')->index();
                $table->string('transactionid',1000)->nullable();
                $table->string('name')->nullable();
                $table->string('amount',300)->nullable();
                $table->string('email')->nullable();
                $table->string('details',1000)->nullable();
                $table->string('status')->nullable()->default(0)->comment('0=pending, 1=complete, 2=reject');
                $table->string('tstatus')->nullable()->comment('1=creadit, 2=debit');
                $table->string('archieve')->nullable()->default(1)->comment('1=archieve, 2=unarchieve');
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
        Schema::dropIfExists('individual_total_transactions');
    }
}
