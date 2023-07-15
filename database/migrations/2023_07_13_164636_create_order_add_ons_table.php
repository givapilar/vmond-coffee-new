<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderAddOnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_add_ons', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("order_pivot_id")->nullable();
            $table->unsignedBigInteger("add_on_id")->nullable();
            $table->unsignedBigInteger("add_on_detail_id")->nullable();
            
            $table->foreign("order_pivot_id")->references("id")->on("order_pivots")->onDelete('cascade');
            $table->foreign("add_on_id")->references("id")->on("add_ons")->onDelete('cascade');
            $table->foreign("add_on_detail_id")->references("id")->on("add_on_details")->onDelete('cascade');
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
        Schema::dropIfExists('order_add_ons');
    }
}
