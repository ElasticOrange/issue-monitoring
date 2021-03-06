<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocumentsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('documents', function (Blueprint $table) {
			$table->increments('id');
			$table->boolean('public');
			$table->integer('uploaded_file_id')->nullable();
			$table->string('public_code')->nullable();
			$table->timestamp('init_at');
			$table->timestamps();
		});
		Schema::create('document_translations', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('document_id')->unsigned();
			$table->string('locale', 3)->index();

			$table->string('description', 1000);

			$table->unique(['document_id','locale']);
			$table->foreign('document_id')->references('id')->on('documents')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('document_translations');
		Schema::dropIfExists('documents');
	}
}
