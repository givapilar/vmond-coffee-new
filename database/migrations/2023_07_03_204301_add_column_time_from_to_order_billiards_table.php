<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnTimeFromToOrderBilliardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_billiards', function (Blueprint $table) {
            $table->dateTime("time_from")->nullable();
            $table->dateTime("time_to")->nullable();
            $table->string("status_pemesanan")->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_billiards', function (Blueprint $table) {
            $table->dropColumn('time_from');
            $table->dropColumn('time_to');
            $table->dropColumn('status_pemesanan');

        });
    }
}
