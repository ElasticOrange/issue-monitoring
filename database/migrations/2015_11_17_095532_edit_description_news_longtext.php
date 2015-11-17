<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditDescriptionNewsLongtext extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('news_translations', function (Blueprint $table) {
			$table->longText('description')->change();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('news_translations', function (Blueprint $table) {
			$table->string('description', 1000)->change();
		});
	}
}
