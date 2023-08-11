<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("user_id")->nullable();
            $table->string("name")->nullable();
            $table->string("phone")->nullable();
            $table->integer("qty")->nullable();
            $table->bigInteger("total_price")->nullable();
            $table->enum('status', ['Unpaid', 'Paid'])->nullable();
            $table->text("description")->nullable();

            $table->foreign("user_id")->references("id")->on("account_users")->onDelete('cascade');
            
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
        Schema::dropIfExists('orders');
    }
}
