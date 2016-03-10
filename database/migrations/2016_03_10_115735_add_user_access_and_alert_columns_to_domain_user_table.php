<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUserAccessAndAlertColumnsToDomainUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('domain_user', function (Blueprint $table) {
            $table->boolean('can_see_issues')->default(1);
            $table->boolean('can_see_news')->default(1);
            $table->boolean('can_see_reports')->default(1);
            $table->boolean('alert_for_issues')->default(1);
            $table->boolean('alert_for_news')->default(1);
            $table->boolean('alert_for_reports')->default(1);
            $table->boolean('can_see_stakeholders')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('domain_user', function (Blueprint $table) {
            $table->dropColumn([
                'can_see_issues',
                'can_see_news',
                'can_see_reports',
                'alert_for_issues',
                'alert_for_news',
                'alert_for_reports',
                'can_see_stakeholders'
            ]);
        });
    }
}
