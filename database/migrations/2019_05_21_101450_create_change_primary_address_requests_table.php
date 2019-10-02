<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChangePrimaryAddressRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('change_primary_address_requests', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('role');
            $table->string('add_line_one',500);
            $table->string('add_line_two',500);
            $table->string('town_or_city');
            $table->string('zip');
            $table->string('state');
            $table->string('country');
            $table->string('address_proof');
            $table->integer('admin_status')->default(0);
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
        Schema::dropIfExists('change_primary_address_requests');
    }
}
