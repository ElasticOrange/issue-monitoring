<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAlertColumnsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('alert_new_issue')->default(1);
            $table->boolean('alert_issue_status')->default(1);
            $table->boolean('alert_news')->default(1);
            $table->boolean('alert_report')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['alert_new_issue', 'alert_issue_status', 'alert_news', 'alert_report']);
        });
    }
}
