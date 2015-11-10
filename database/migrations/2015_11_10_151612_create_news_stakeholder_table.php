<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewsStakeholderTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('news_stakeholder', function (Blueprint $table) {
			$table->increments('id');

			$table->integer('news_id')->unsigned()->index();
			$table->foreign('news_id')->references('id')->on('news')->onDelete('cascade');

			$table->integer('stakeholder_id')->unsigned()->index();
			$table->foreign('stakeholder_id')->references('id')->on('stakeholders')->onDelete('cascade');

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
		Schema::dropIfExists('news_stakeholder');
	}
}
