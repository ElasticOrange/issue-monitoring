<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditColumnsEmailTelephoneNullable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('ALTER TABLE stakeholders MODIFY email varchar(255) NULL;');
        DB::statement('ALTER TABLE `stakeholders` MODIFY `telephone` varchar(255) NULL;');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('ALTER TABLE `stakeholders` MODIFY `email` varchar(255) NOT NULL;');
        DB::statement('ALTER TABLE `stakeholders` MODIFY `telephone` varchar(255) NOT NULL;');
    }
}
