<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('news', function (Blueprint $table) {
			$table->increments('id');
			$table->timestamp('date');
			$table->string('link');
			$table->boolean('published');
			$table->timestamps();
		});

		Schema::create('news_translations', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('news_id')->unsigned();
			$table->string('locale', 3)->index();

			$table->string('title');
			$table->string('description',1000);

			$table->unique(['news_id','locale']);
			$table->foreign('news_id')->references('id')->on('news')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('news_translations');
		Schema::drop('news');
	}
}
