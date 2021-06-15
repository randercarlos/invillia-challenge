<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShipOrderDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ship_order_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ship_order_id');
            $table->string('title');
            $table->string('note');
            $table->string('quantity');
            $table->string('price');

            $table->foreign('ship_order_id')->references('id')->on('ship_orders')
                ->onUpdate('cascade')->onDelete('cascade');

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
        Schema::dropIfExists('ship_order_details');
    }
}
