<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocumentFlowStepTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('document_flow_step', function (Blueprint $table) {
			$table->increments('id');

			$table->integer('flow_step_id')->unsigned()->index();
			$table->foreign('flow_step_id')->references('id')->on('flow_steps')->onDelete('cascade');

			$table->integer('document_id')->unsigned()->index();
			$table->foreign('document_id')->references('id')->on('documents')->onDelete('cascade');

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
		Schema::dropIfExists('document_flow_step');
	}
}
