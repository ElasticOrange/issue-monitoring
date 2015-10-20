<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStakeholdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stakeholder', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('type');
            $table->string('site');
            $table->string('download_code', 30);
            $table->boolean('published');
            $table->timestamps();
        });
        Schema::create('stakeholder_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('document_id')->unsigned();
            $table->string('locale', 3)->index();

            $table->string('contact', 1000);
            $table->string('profile', 1000);
            $table->string('position', 1000);

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
        Schema::drop('stakeholders');
    }
}

