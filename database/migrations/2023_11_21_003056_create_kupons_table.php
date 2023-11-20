<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKuponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kupons', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("order_id")->nullable();
            
            $table->string('code')->nullable();
            $table->foreign("order_id")->references("id")->on("orders")->onDelete('cascade');
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
        Schema::dropIfExists('kupons');
    }
}
