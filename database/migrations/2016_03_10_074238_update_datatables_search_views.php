<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateDatatablesSearchViews extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("CREATE VIEW legal_news_search AS SELECT legal_news.id,concat(`title`, `content`, `issue_id`) AS content FROM legal_news JOIN legal_news_translations ON legal_news.id=legal_news_translations.legal_news_id");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW legal_news_search");
    }
}
