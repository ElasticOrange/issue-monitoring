<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyStakeholdersSearchView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("DROP VIEW stakeholders_search");
        sleep(2);
        DB::statement("CREATE VIEW stakeholders_search AS SELECT stakeholders.id,concat(`name`, `org_name`, `type`, `site`, `link`, `email`, `telephone`, `position`, `address`, `other_details`) AS content FROM stakeholders JOIN stakeholder_translations ON stakeholders.id=stakeholder_translations.stakeholder_id");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW stakeholders_search");
        sleep(2);
        DB::statement("CREATE VIEW stakeholders_search AS SELECT stakeholders.id,concat(`name`, `type`, `site`, `link`, `email`, `telephone`, `position`, `address`, `other_details`) AS content FROM stakeholders JOIN stakeholder_translations ON stakeholders.id=stakeholder_translations.stakeholder_id");
    }
}
