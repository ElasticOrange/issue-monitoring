<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLegalNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('legal_news', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('published');
            $table->integer('issue_id');
            $table->timestamps();
        });

		Schema::create('legal_news_translations', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('legal_news_id')->unsigned();
			$table->string('locale', 2)->index();

			$table->string('title', 1000);
			$table->string('content', 1000);

			$table->unique(['legal_news_id','locale']);
			$table->foreign('legal_news_id')->references('id')->on('legal_news')->onDelete('cascade');
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('legal_news_translations');
        Schema::dropIfExists('legal_news');
    }
}
