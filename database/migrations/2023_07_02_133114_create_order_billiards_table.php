<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderBilliardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_billiards', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("order_id")->nullable();
            $table->unsignedBigInteger("restaurant_id")->nullable();
            $table->unsignedBigInteger("paket_menu_id")->nullable();
            $table->string("category")->nullable();
            $table->integer("qty")->nullable();

            
            $table->foreign("order_id")->references("id")->on("orders")->onDelete('cascade');
            $table->foreign("restaurant_id")->references("id")->on("restaurants")->onDelete('cascade');
            $table->foreign("paket_menu_id")->references("id")->on("menu_packages")->onDelete('cascade');
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
        Schema::dropIfExists('order_billiards');
    }
}
