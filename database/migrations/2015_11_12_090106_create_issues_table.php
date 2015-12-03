<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIssuesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('issues', function (Blueprint $table) {
			$table->increments('id');
			$table->string('public_code');
			$table->timestamps();
		});

		Schema::create('issue_translations', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('issue_id')->unsigned();
			$table->string('locale', 3)->index();

			$table->string('name');
			$table->string('description', 1000);
			$table->string('impact', 1000);
			$table->string('status', 1000);

			$table->unique(['issue_id','locale']);
			$table->foreign('issue_id')->references('id')->on('issues')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('issue_translations');
		Schema::drop('issues');
	}
}
