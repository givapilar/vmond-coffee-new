<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnJenisMejaToAccountUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('account_users', function (Blueprint $table) {
            $table->string("jenis_meja")->nullable();
            $table->integer("no_meja")->nullable();
            $table->boolean('is_worker')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('account_users', function (Blueprint $table) {
            $table->dropColumn('jenis_meja');
            $table->dropColumn('no_meja');
            $table->dropColumn('is_worker');
        });
    }
}
