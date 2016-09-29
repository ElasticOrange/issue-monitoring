<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class IncreaseCharactersLimitForIssueTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('issue_translations', function (Blueprint $table) {
            $table->longText('name')->change();
            $table->longText('impact')->change();
            $table->longText('status')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('issue_translations', function (Blueprint $table) {
            $table->string('name', 1000)->change();
            $table->string('impact', 1000)->change();
            $table->string('status', 1000)->change();
        });
    }
}
