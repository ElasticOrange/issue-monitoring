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
            $table->boolean('online');
            $table->string('proposalid');
            $table->string('stageid');
            $table->string('filespath')->nullable();
            $table->string('link')->nullable();
            $table->timestamp('initat');
            $table->timestamps();
        });
        Schema::create('document_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('document_id')->unsigned();
            $table->string('locale')->index();

            $table->string('description');

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