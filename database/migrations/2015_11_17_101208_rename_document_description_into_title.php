<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameDocumentDescriptionIntoTitle extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('document_translations', function (Blueprint $table) {
			$table->renameColumn('description', 'title');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('document_translations', function (Blueprint $table) {
			$table->renameColumn('title', 'description');
		});
	}
}
