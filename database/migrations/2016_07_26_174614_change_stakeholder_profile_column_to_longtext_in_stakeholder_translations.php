<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeStakeholderProfileColumnToLongtextInStakeholderTranslations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('stakeholder_translations', function (Blueprint $table) {
            $table->longText('profile')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('stakeholder_translations', function (Blueprint $table) {
            $table->string('profile', 1000)->change();
        });
    }
}
