<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDomainNewsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('domain_news', function (Blueprint $table) {
			$table->increments('id');

			$table->integer('domain_id')->unsigned()->index();
			$table->foreign('domain_id')->references('id')->on('domains')->onDelete('cascade');

			$table->integer('news_id')->unsigned()->index();
			$table->foreign('news_id')->references('id')->on('news')->onDelete('cascade');

			$table->timestamps();
		});
	}

	 /**
	  * Reverse the migrations.
	  *
	  * @return void
	  */

	public function down()
	{
		Schema::dropIfExists('domain_news');
	}
}
