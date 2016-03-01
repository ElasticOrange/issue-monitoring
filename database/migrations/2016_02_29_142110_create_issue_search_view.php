<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIssueSearchView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement( "CREATE VIEW issues_search AS SELECT issues.id,concat(`phase`, `type`, `name`, `description`, `status`, `impact`) as content FROM issues join issue_translations ON issues.id=issue_translations.issue_id" );

        DB::statement( "CREATE VIEW users_search AS SELECT users.id,concat(`name`, `email`, `company`, `observations`) as content FROM users" );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement( 'DROP VIEW issues_search' );    
        DB::statement( 'DROP VIEW users_search' );    
    }
}
