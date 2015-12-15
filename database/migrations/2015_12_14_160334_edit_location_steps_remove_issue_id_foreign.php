<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditLocationStepsRemoveIssueIdForeign extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('location_steps', function (Blueprint $table) {
            $table->dropForeign('location_steps_issue_id_foreign');
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
            $table->foreign('issue_id')->references('id')->on('issues')->onDelete('cascade');
        });
    }
}
