<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoiceItemsListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_items_lists', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('create_invoice_id');
            $table->string('item_name');
            $table->string('item_desc',1000)->nullable();
            $table->string('item_quantity')->default(0);
            $table->string('item_price')->default(0);            
            $table->string('item_tax_id')->nullable();                    
            $table->string('item_amount')->default(0);            
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
        Schema::dropIfExists('invoice_items_lists');
    }
}
