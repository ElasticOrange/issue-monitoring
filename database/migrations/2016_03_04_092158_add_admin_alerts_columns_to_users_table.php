<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAdminAlertsColumnsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('admin_alert_new_issue')->default(1);
            $table->boolean('admin_alert_issue_status')->default(1);
            $table->boolean('admin_alert_news')->default(1);
            $table->boolean('admin_alert_report')->default(1);
            $table->boolean('admin_alert_issue_stage')->default(1);
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
            $table->dropColumn(['admin_alert_new_issue', 'admin_alert_issue_status', 'admin_alert_news', 'admin_alert_report', 'admin_alert_issue_stage']);
        });
    }
}
