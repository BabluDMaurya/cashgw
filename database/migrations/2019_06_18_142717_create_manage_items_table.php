<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateManageItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('manage_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id');            
            $table->string('item_name')->nullable();
            $table->string('description',1000);  
            $table->string('price')->nullable();  
            $table->integer('status')->default(0);
            $table->string('tax_name')->nullable();
            $table->string('rate')->nullable();              
            $table->string('invoice_cat_id')->nullable();  
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('manage_items');
    }
}
