<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sections', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('stakeholder_id')->unsigned()->index();
            $table->timestamps();

            // $table->index(['stakeholder_id']);
            $table->foreign('stakeholder_id')->references('id')->on('stakeholders')->onDelete('cascade');
        });

        Schema::create('section_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('section_id')->unsigned();
            $table->string('locale', 3)->index();

            $table->string('title');
            $table->string('description',1000);

            $table->unique(['section_id','locale']);
            $table->foreign('section_id')->references('id')->on('sections')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('section_translations');
        Schema::drop('sections');
    }
}
