<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnPaketToOrderPivotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_pivots', function (Blueprint $table) {
            $table->unsignedBigInteger("paket_menu_id")->nullable();
            
            $table->foreign("paket_menu_id")->references("id")->on("menu_packages")->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_pivots', function (Blueprint $table) {
            //
        });
    }
}
