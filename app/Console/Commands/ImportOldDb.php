<?php

namespace Issue\Console\Commands;

use Illuminate\Console\Command;
use DB;
use App;
use Issue\User;
use Issue\StepAutocomplete;
use Issue\Stakeholder;
use Issue\Domain;

class ImportOldDb extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:olddb {sql_file} {db_user} {db_name} {db_password}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Imports old database';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    protected function createDb($db_name)
    {
        DB::statement('CREATE DATABASE IF NOT EXISTS '.$db_name);

        return print_r('Created database '.$db_name."\n");
    }

    protected function createUserWithPrivileges($db_name, $db_user, $db_password)
    {
        DB::statement('GRANT ALL PRIVILEGES ON *.* TO '."'".$db_user."'@"."'localhost' IDENTIFIED BY "."'".$db_password."';");

        return print_r('Created user '.$db_user.' with password '.$db_password.' and granted all privileges to '.$db_name."\n");
    }

    protected function importOldDb($db_name, $db_user, $db_password, $sql_file)
    {
        if (App::runningInConsole())
        {
            echo exec('mysql -u '.$db_user.' -p'.$db_password.' '.$db_name.' < '.base_path().'/'.$sql_file);
        }

        return print_r('Database succesfully imported'."\n");
    }

    protected function importUsers()
    {
        $users = DB::connection('oldissue')->select('select * from users');
        foreach ($users as $user) {

            $newUser = new User;
            $newUser->id = $user->id;
            $newUser->name = $user->name;
            $newUser->email = $user->email;
            $newUser->password = $user->password;
            
            if ($user->banned === 'N' && $user->active === 'Y') {
                $newUser->active = true;
            } else {
                $newUser->active = false;
            }

            if ($user->profilesId === '1') {
                $newUser->type = 'admin';
            } elseif ($user->profilesId === '2') {
                $newUser->type = 'editor';
            } elseif ($user->profilesId === '4') {
                $newUser->type = 'client';
            }


            $newUser->save();
        }

        return print_r('Au fost importati: '.User::count().' useri.'."\n");
    }

    protected function importStepAutocompletes()
    {
        $stepAutocompletes = DB::connection('oldissue')->select('select * from syslexsteps');
        foreach ($stepAutocompletes as $step) {

            $newStepAutocomplete = new StepAutocomplete;
            $newStepAutocomplete->id = $step->lexstepID;
            $newStepAutocomplete->name = $step->description;

            $newStepAutocomplete->save();
        }

        return print_r('Au fost importati: '.StepAutocomplete::count().' stepAutocomplete.'."\n");
    }

    protected function importStakeholders()
    {
        $stakeholders = DB::connection('oldissue')->select('select * from stackeholders');
        foreach ($stakeholders as $stakeholder) {

            $newStakeholder = new Stakeholder;

            $newStakeholder->id = $stakeholder->stackeholderID;
            $newStakeholder->name = $stakeholder->first_name.' '.$stakeholder->last_name;

            if ($stakeholder->isauth === '0') {
                $newStakeholder->type = 'persoana';
            } else {
                $newStakeholder->type = 'organizatie';
            }

            $newStakeholder->site = $stakeholder->blog;
            $newStakeholder->email = $stakeholder->email;
            $newStakeholder->telephone = $stakeholder->phone;
            $newStakeholder->public_code = str_random(40);

            $translatableData = [
                'ro' =>[
                    'profile' => $stakeholder->profile ? $stakeholder->profile : '',
                    'position' => $stakeholder->posAndApart ? $stakeholder->posAndApart : '',
                    'address' => $stakeholder->contact ? $stakeholder->contact : '',
                ],
                'en' => [
                    'profile' => $stakeholder->enprofile ? $stakeholder->enprofile : '',
                    'position' => $stakeholder->enposAndApart ? $stakeholder->enposAndApart : '',
                    'address' => $stakeholder->encontact ? $stakeholder->encontact : '',
                ]
            ];

            $newStakeholder->fill($translatableData);
            $newStakeholder->save();
        }

        return print_r('Au fost importati: '.Stakeholder::count().' stakeholders.'."\n");
    }

    protected function importDomains()
    {
        $domain = Domain::create([
            'parent_id' => 0,
        ]);

        $domainNames = [ 'ro' => 'Domenii', 'en' => 'Domains'];
        foreach (['ro', 'en'] as $locale) {
            $domain->translateOrNew($locale)->name = $domainNames[$locale];
        }

        $domain->save();

        $lvl1domains = DB::connection('oldissue')->select('select * from syslexdomain');
        $lvl2domains = DB::connection('oldissue')->select('select * from syslexarea');

        foreach ($lvl1domains as $domain) {

            $newDomain = new Domain;
            $newDomain->id = $domain->lexdomainID;
            $newDomain->parent_id = 1;

            $translatableData = [
                'ro' =>[
                    'name' => $domain->name ? $domain->name : '',
                ],
                'en' => [
                    'name' => $domain->enname ? $domain->enname : '',
                ]
            ];

            $newDomain->fill($translatableData);

            $newDomain->save();
        }

        foreach ($lvl2domains as $domain) {

            $newDomain = new Domain;
            $newDomain->id = $domain->lexareaID;
            $newDomain->parent_id = $domain->domainID;

            $translatableData = [
                'ro' =>[
                    'name' => $domain->name ? $domain->name : '',
                ],
                'en' => [
                    'name' => $domain->enname ? $domain->enname : '',
                ]
            ];

            $newDomain->fill($translatableData);

            $newDomain->save();
        }

        return print_r('Au fost importate: '.Domain::count().' domenii.'."\n");
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->createDb($this->argument('db_name'));
        $this->createUserWithPrivileges($this->argument('db_name'), $this->argument('db_user'), $this->argument('db_password'));
        $this->importOldDb($this->argument('db_name'), $this->argument('db_user'), $this->argument('db_password'), $this->argument('sql_file'));


        DB::beginTransaction();

        try {

            $this->importUsers();
            $this->importStepAutocompletes();
            $this->importStakeholders();
            $this->importDomains();


            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            print_r('Shiit! Rollback happened.');
        }
    }
}
