<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFlowStepsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('flow_steps', function (Blueprint $table) {
			$table->increments('id');
			$table->string('flow_name');
			$table->integer('estimated_duration');
			$table->timestamp('start_date');
			$table->timestamp('end_date');

			$table->integer('location_step_id')->unsigned()->index();

			$table->integer('issue_id')->unsigned();
			$table->foreign('issue_id')->references('id')->on('issues')->onDelete('cascade');

			$table->integer('flowstep_order')->unsigned();

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
		Schema::dropIfExists('flow_steps');
	}
}
