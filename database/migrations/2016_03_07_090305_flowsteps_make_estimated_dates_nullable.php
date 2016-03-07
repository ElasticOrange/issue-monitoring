<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FlowstepsMakeEstimatedDatesNullable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('ALTER TABLE `flow_steps` MODIFY `start_date` TIMESTAMP NULL;');
        DB::statement('ALTER TABLE `flow_steps` MODIFY `end_date` TIMESTAMP NULL;');
    } 
    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('ALTER TABLE `flow_steps` MODIFY `start_date` TIMESTAMP NOT NULL;');
        DB::statement('ALTER TABLE `flow_steps` MODIFY `end_date` TIMESTAMP NOT NULL;');
    }
}
