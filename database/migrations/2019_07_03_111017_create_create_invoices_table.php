<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('create_invoices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id');
            $table->integer('invoice_cat_id');
            $table->string('invoice_number')->nullable();
            $table->string('transaction_id',1000)->nullable();
            $table->string('invoice_date')->nullable();
            $table->string('reference')->nullable();
            $table->string('business_logo')->nullable();
            $table->string('business_name')->nullable();
            $table->string('first_name')->nullable();
            $table->string('address',500)->nullable();
            $table->string('phone')->nullable();
            $table->string('email_id')->nullable();
            $table->string('due_date_value')->nullable();            
            $table->string('bill_to_email')->nullable();
            $table->string('cc_email')->nullable();        
            $table->string('notes_to_recepient',3000)->nullable();   
            $table->string('terms_and_conditions',3000)->nullable();   
            $table->string('attach_file')->nullable();     
            $table->string('add_memo_to_self',3000)->nullable();   
            $table->string('invoice_subtotal')->default(0)->nullable();
            $table->string('invoice_discount_in_percent')->default(0)->nullable();
            $table->string('invoice_discount_in_value')->default(0)->nullable();
            $table->string('invoice_shipping')->default(0)->nullable();  
            $table->string('invoice_grand_total')->default(0)->nullable();
            $table->string('currency')->nullable();  
            $table->string('tax_id')->nullable(); 
            $table->integer('invoice_status')->nullable();
            $table->integer('reminder_count')->default(0)->nullable();  	
            $table->integer('archived_status')->default(1)->nullable();  	
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
        Schema::dropIfExists('create_invoices');
    }
}
