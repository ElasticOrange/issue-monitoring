<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPublicaAndArhivatColumnsToIssuesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('issues', function (Blueprint $table) {
			$table->boolean('archived');
			$table->boolean('published');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('issues', function (Blueprint $table) {
			$table->dropColumn(['published', 'archived']);
		});
	}
}
