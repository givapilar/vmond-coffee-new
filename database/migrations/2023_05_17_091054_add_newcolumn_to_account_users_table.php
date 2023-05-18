<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewcolumnToAccountUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('account_users', function (Blueprint $table) {
            $table->string('username')->default('-');
            $table->text('avatar')->nullable();
            $table->double('balance')->default(0);
            $table->text('address')->nullable();
            $table->enum('status', ['aktif', 'nonaktif', 'verifikasi'])->default('nonaktif');
            $table->double('point')->default(0);
            $table->string('telephone')->default('-');
            $table->string('history_login')->nullable()->default(date('Y-m-d H:i:s'));
            $table->string('registration_date')->default(date('Y-m-d H:i:s'));
            $table->dropColumn('name');
            $table->string('email')->nullable()->change();
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
            $table->dropColumn('username');
            $table->dropColumn('avatar');
            $table->dropColumn('balance');
            $table->dropColumn('address');
            $table->dropColumn('status');
            $table->dropColumn('point');
            $table->dropColumn('telephone');
            $table->dropColumn('history_login');
            $table->dropColumn('registration_date');
            $table->string('name');
            $table->string('email')->change();
        });
    }
}
