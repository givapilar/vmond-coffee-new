<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnHargaToOrderPivotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_pivots', function (Blueprint $table) {
            $table->float('harga')->nullable();
            $table->float('harga_diskon')->nullable();
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
            $table->dropColumn('harga');
            $table->dropColumn('harga_diskon');
            
        });
    }
}
