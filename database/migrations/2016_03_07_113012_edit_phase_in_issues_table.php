<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditPhaseInIssuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('issues', function (Blueprint $table) {
            DB::statement("ALTER TABLE issues MODIFY COLUMN phase ENUM('viitor', 'curent', 'arhivatRespinsSauAbrogat', 'arhivatInactiv', 'publicatMO') DEFAULT 'viitor' NOT NULL");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('issues', function (Blueprint $table) {
            DB::statement("ALTER TABLE issues MODIFY COLUMN phase ENUM('viitor', 'curent', 'arhivatPublicat', 'arhivatRespins') DEFAULT 'viitor' NOT NULL");
        });
    }
}
