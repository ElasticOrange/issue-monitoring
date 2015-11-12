<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIssueStakeholderTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('issue_stakeholder', function (Blueprint $table) {
			$table->increments('id');

			$table->integer('issue_id')->unsigned()->index();
			$table->foreign('issue_id')->references('id')->on('issues')->onDelete('cascade');

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
		Schema::dropIfExists('issue_stakeholder');
	}
}
