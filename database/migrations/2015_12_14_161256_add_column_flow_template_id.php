<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnFlowTemplateId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('location_steps', function (Blueprint $table) {
            $table->integer('flow_template_id')->unsigned()->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('location_steps', function (Blueprint $table) {
            $table->dropColumn(['flow_template_id']);
        });
    }
}
