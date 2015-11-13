<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInitiatorIssueTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('initiator_issue', function (Blueprint $table) {
			$table->increments('id');

			$table->integer('initiator_id')->unsigned()->index();
			$table->foreign('initiator_id')->references('id')->on('stakeholders')->onDelete('cascade');

			$table->integer('issue_id')->unsigned()->index();
			$table->foreign('issue_id')->references('id')->on('issues')->onDelete('cascade');

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
		Schema::dropIfExists('initiator_issue');
	}
}
