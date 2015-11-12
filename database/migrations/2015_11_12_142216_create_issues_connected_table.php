<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIssuesConnectedTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('issues_connected', function (Blueprint $table) {
			$table->increments('id');

			$table->integer('issue_id')->unsigned()->index();
			$table->foreign('issue_id')->references('id')->on('issues')->onDelete('cascade');

			$table->integer('issue_connected_id')->unsigned()->index();

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
		Schema::drop('issues_connected');
	}
}
