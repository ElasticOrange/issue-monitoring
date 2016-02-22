<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditColumnLengthAddressFromStakeholderTranslations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('stakeholder_translations', function (Blueprint $table) {
            $table->longtext('address')->change();
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
            $table->string('address', 1000)->change();
        });
    }
}
