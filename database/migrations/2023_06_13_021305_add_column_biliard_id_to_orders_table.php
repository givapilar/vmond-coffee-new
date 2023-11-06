<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnBiliardIdToOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->unsignedBigInteger("biliard_id")->nullable();
            $table->unsignedBigInteger("meeting_room_id")->nullable();
            $table->string("category")->nullable();
            $table->date("date")->nullable();
            $table->time("time_from")->nullable();
            $table->time("time_to")->nullable();

            
            $table->foreign("biliard_id")->references("id")->on("biliards")->onDelete('cascade');
            $table->foreign("meeting_room_id")->references("id")->on("meeting_rooms")->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            //
        });
    }
}
