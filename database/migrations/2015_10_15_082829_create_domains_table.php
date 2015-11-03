<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDomainsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('domains', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('parent_id');
			$table->timestamps();
		});
		Schema::create('domain_translations', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('domain_id')->unsigned();
			$table->string('locale', 3)->index();
			$table->string('name');
			$table->unique(['domain_id','locale']);
			$table->foreign('domain_id')->references('id')->on('domains')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('domain_translations');
		Schema::dropIfExists('domains');
	}
}
