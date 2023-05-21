<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartOrderPivotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cart_order_pivots', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cart_order_id')->nullable();
            $table->unsignedBigInteger('restaurant_id')->nullable();
            $table->bigInteger("qty");

            $table->foreign("cart_order_id")->references("id")->on("cart_orders");
            $table->foreign("restaurant_id")->references("id")->on("restaurants");
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
        Schema::dropIfExists('cart_order_pivots');
    }
}
