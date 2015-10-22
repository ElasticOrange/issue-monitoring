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
        Schema::create('stakeholders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->enum('type',['persoana','organizatie']);
            $table->string('site');
            $table->string('download_code', 30);
            $table->boolean('published')->nullable();
            $table->timestamps();
        });
        Schema::create('stakeholder_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('stakeholder_id')->unsigned();
            $table->string('locale', 3)->index();

            $table->string('contact', 1000);
            $table->string('profile', 1000);
            $table->string('position', 1000);

            $table->unique(['stakeholder_id','locale']);
            $table->foreign('stakeholder_id')->references('id')->on('stakeholders')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('stakeholder_translations');
        Schema::drop('stakeholders');

    }
}

