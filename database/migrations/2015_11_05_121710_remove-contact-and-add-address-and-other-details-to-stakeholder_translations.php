<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveContactAndAddAddressAndOtherDetailsToStakeholderTranslations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('stakeholder_translations', function ($table) {
            $table->dropColumn('contact');
            $table->string('address');
            $table->string('other_details', 1000);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('stakeholder_translations', function ($table) {
            $table->string('contact');
            $table->dropColumn(['address', 'other_details']);
        });
    }
}
