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

        DB::statement( "CREATE VIEW stakeholders_search AS SELECT stakeholders.id,concat(`name`, `type`, `site`, `link`, `email`, `telephone`, `position`, `address`, `other_details`) as content FROM stakeholders join stakeholder_translations ON stakeholders.id=stakeholder_translations.stakeholder_id" );

        DB::statement( "CREATE VIEW documents_search AS SELECT documents.id,concat(`title`) as content FROM documents join document_translations ON documents.id=document_translations.document_id" );

        DB::statement( "CREATE VIEW news_search AS SELECT news.id,concat(`link`, `title`, `description`) as content FROM news join news_translations ON news.id=news_translations.news_id" );
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
        DB::statement( 'DROP VIEW stakeholders_search' );
        DB::statement( 'DROP VIEW documents_search' );
        DB::statement( 'DROP VIEW news_search' );
    }
}
