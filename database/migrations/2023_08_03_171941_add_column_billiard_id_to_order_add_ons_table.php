<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnBilliardIdToOrderAddOnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_add_ons', function (Blueprint $table) {
            $table->unsignedBigInteger("order_billiard_id")->nullable();
            
            $table->foreign("order_billiard_id")->references("id")->on("order_billiards")->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_add_ons', function (Blueprint $table) {
            $table->dropColumn('order_billiard_id');
        });
    }
}
