<?php

namespace Issue\Console\Commands;

use DB;
use Issue\Stakeholder;
use Illuminate\Console\Command;

class ImportStakeholderProfile extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stakeholders:profile';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import stakeholder profile';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    protected function importStakeholdersProfile()
    {
        $stakeholders = DB::connection('oldissue')->select('select stackeholderId,profile,enprofile from stackeholders');

        foreach ($stakeholders as $stakeholder) {

            $oldStakeholder = Stakeholder::find($stakeholder->stackeholderId);
            if ($oldStakeholder) {
                $translatableData = [
                    'ro' =>[
                        'profile' => $stakeholder->profile ? $stakeholder->profile : '',
                    ],
                    'en' => [
                        'profile' => $stakeholder->enprofile ? $stakeholder->enprofile : '',
                    ]
                ];

                $oldStakeholder->fill($translatableData);
                $oldStakeholder->save();
            }
        }

        echo sprintf("Au fost updatati: %s stakeholders.\n", Stakeholder::count());
        return true;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        DB::beginTransaction();

        try {
            $this->importStakeholdersProfile();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            print_r('Shiit! Rollback happened.');
        }
    }
}
