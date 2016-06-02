<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditFlowStepsColumnEstimatedDurationToBeNullable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('flow_steps', function (Blueprint $table) {
            $table->integer('estimated_duration')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('flow_steps', function (Blueprint $table) {
            $table->integer('estimated_duration')->nullable(false)->change();
        });
    }
}
