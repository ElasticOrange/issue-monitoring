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
        DB::statement("CREATE VIEW issues_search AS SELECT issues.id,concat(`phase`, `type`, `name`, `description`, `status`, `impact`) AS content FROM issues JOIN issue_translations ON issues.id=issue_translations.issue_id");

        DB::statement("CREATE VIEW users_search AS SELECT users.id,concat(`name`, `email`, `company`, `observations`) AS content FROM users");

        DB::statement("CREATE VIEW stakeholders_search AS SELECT stakeholders.id,concat(`name`, `type`, `site`, `link`, `email`, `telephone`, `position`, `address`, `other_details`) AS content FROM stakeholders JOIN stakeholder_translations ON stakeholders.id=stakeholder_translations.stakeholder_id");

        DB::statement("CREATE VIEW documents_search AS SELECT documents.id,concat(`title`) AS content FROM documents JOIN document_translations ON documents.id=document_translations.document_id");

        DB::statement("CREATE VIEW news_search AS SELECT news.id,concat(`link`, `title`, `description`) AS content FROM news JOIN news_translations ON news.id=news_translations.news_id");

        DB::statement("CREATE VIEW stepsautocomplete_search AS SELECT step_autocompletes.id,concat(`name`) AS content FROM step_autocompletes");

        DB::statement("CREATE VIEW reports_search AS SELECT reports.id,concat(`title`, `description`) AS content FROM reports JOIN report_translations ON reports.id=report_translations.report_id");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW issues_search");    
        DB::statement("DROP VIEW users_search");    
        DB::statement("DROP VIEW stakeholders_search");
        DB::statement("DROP VIEW documents_search");
        DB::statement("DROP VIEW news_search");
        DB::statement("DROP VIEW stepsautocomplete_search");
        DB::statement("DROP VIEW reports_search");
    }
}
