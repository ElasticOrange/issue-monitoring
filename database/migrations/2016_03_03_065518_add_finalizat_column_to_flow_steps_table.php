<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFinalizatColumnToFlowStepsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('flow_steps', function (Blueprint $table) {
            $table->boolean('finalizat');
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
            $table->dropColumn('finalizat');
        });
    }
}
