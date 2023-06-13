<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropColumnMembershipToAccountUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('account_users', function (Blueprint $table) {
            $table->dropColumn("membership");
            $table->unsignedBigInteger("membership_id")->nullable();

            $table->foreign("membership_id")->references("id")->on("memberships")->onDelete('cascade');
            
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
            $table->enum('membership', ['bronze','silver', 'gold', 'platinum'])->default('bronze');
            $table->dropColumn("membership_id");

        });
    }
}
