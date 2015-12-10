<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNrInregistrareColumnToLocationStepsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('location_steps', function (Blueprint $table) {
            $table->string('nr_inregistrare');
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
            $table->dropColumn('nr_inregistrare');
        });
    }
}
