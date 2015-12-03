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

			$table->integer('flowstep_order')->unsigned();

			$table->timestamps();
		});

		Schema::create('flow_step_translations', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('flow_step_id')->unsigned();
			$table->string('locale', 3)->index();

			$table->longText('observatii');

			$table->unique(['flow_step_id','locale']);
			$table->foreign('flow_step_id')->references('id')->on('flow_steps')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('flow_step_translations');
		Schema::dropIfExists('flow_steps');
	}
}
