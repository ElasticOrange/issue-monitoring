<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class StakeholderConnectedTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('stakeholders_connected', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('stakeholder_id')->unsigned();
			$table->integer('stakeholder_connected_id')->unsigned();
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
		Schema::dropIfExists('stakeholders_connected');
	}
}
