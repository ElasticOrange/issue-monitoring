<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamp('date');
            $table->string('public_code');
            $table->integer('uploaded_file_id');
            $table->timestamps();
        });

        Schema::create('report_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('report_id')->unsigned();
            $table->string('locale', 3)->index();

            $table->string('title', 1000);
            $table->longText('description');

            $table->unique(['report_id','locale']);
            $table->foreign('report_id')->references('id')->on('reports')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('report_translations');
        Schema::dropIfExists('reports');
    }
}
