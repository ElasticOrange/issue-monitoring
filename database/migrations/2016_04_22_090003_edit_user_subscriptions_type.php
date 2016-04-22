<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditUserSubscriptionsType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_subscriptions', function (Blueprint $table) {
            DB::statement("ALTER TABLE user_subscriptions MODIFY COLUMN type ENUM('trial', 'limited', 'unlimited') DEFAULT 'trial' NOT NULL");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_subscriptions', function (Blueprint $table) {
            DB::statement("ALTER TABLE user_subscriptions MODIFY COLUMN type ENUM('limited', 'unlimited') DEFAULT 'limited' NOT NULL");
        });
    }
}
