<?php

namespace Issue\Console\Commands;

use Illuminate\Console\Command;
use DB;
use App;
use Issue\User;
use Issue\StepAutocomplete;
use Issue\Stakeholder;
use Issue\Domain;
use Issue\News;
use Issue\Location;
use Issue\Issue;

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
            $newStakeholder->email = $stakeholder->email ? $stakeholder->email : '';
            $newStakeholder->telephone = $stakeholder->phone ?$stakeholder->phone : '';
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

    protected function importNews()
    {
        $news = DB::connection('oldissue')->select('select * from relatednewsandstatments');

        foreach ($news as $n) {
            $newNews = new News;
            $newNews->id = $n->id;
            $newNews->date = $n->initat;
            $newNews->link = $n->link ? $n->link : '';
            $newNews->public_code = str_random(40);

            $translatableData = [
                'ro' =>[
                    'title' => $n->title ? $n->title : '',
                    'description' => $n->content ? $n->content : '',
                ],
                'en' => [
                    'title' => $n->entitle ? $n->entitle : '',
                    'description' => $n->encontent ? $n->encontent : '',
                ]
            ];

            $newNews->fill($translatableData);

            $newNews->save();
        }

        return print_r('Au fost importate: '.News::count().' stiri.'."\n");
    }

    protected function importLocations()
    {
        $location = Location::create([
            'parent_id' => 0,
        ]);

        $locationNames = [ 'ro' => 'Locatii', 'en' => 'Locations'];
        foreach (['ro', 'en'] as $locale) {
            $location->translateOrNew($locale)->name = $locationNames[$locale];
        }

        $location->save();

        $locations = DB::connection('oldissue')->select('select * from lexlocation');

        foreach ($locations as $location) {
            $newLocation = new Location;
            $newLocation->id = $location->id+1;
            $newLocation->parent_id = $location->parentid+1;

            $translatableData = [
                'ro' =>[
                    'name' => $location->name ? $location->name : '',
                ],
                'en' => [
                    'name' => $location->enname ? $location->enname : '',
                ]
            ];

            $newLocation->fill($translatableData);

            $newLocation->save();
        }

        return print_r('Au fost importate: '.Location::count().' locatii procedurale.'."\n");
    }

    protected function importIssues()
    {
        $issues = DB::connection('oldissue')->select('select * from initlaws where currentphase=1');

        foreach ($issues as $issue) {
            $newIssue = new Issue;
            $newIssue->id = $issue->propid;
            $newIssue->public_code = str_random(40);
            $newIssue->archived = false;

// de modificat cand primesc raspuns de la alexandra
            if ($issue->issuestatus === 'ARCHIVED' || $issue->issuestatus === 'ENDSTAGE'
                || $issue->issuestatus === 'COMPLETE' || $issue->issuestatus === 'REFERRED_BACK') {
                $newIssue->phase = 'arhivat';
            } elseif ($issue->issuestatus === 'INPROGRESS') {
                $newIssue->phase = 'curent';
            }

            $translatableData = [
                'ro' =>[
                    'name' => $issue->name ? $issue->name : '',
                    'description' => $issue->description ? $issue->description : '',
                    'impact' => $issue->impact ? $issue->impact : '',
                    'status' => $issue->observatii ? $issue->observatii : '',
                ],
                'en' => [
                    'name' => $issue->enname ? $issue->enname : '',
                    'description' => $issue->endescription ? $issue->endescription : '',
                    'impact' => $issue->enimpact ? $issue->enimpact : '',
                    'status' => $issue->enobservatii ? $issue->enobservatii : '',
                ]
            ];

            $newIssue->fill($translatableData);

            $newIssue->save();
        }

        return print_r('Au fost importate: '.Issue::count().' initiative.'."\n");
    }

    protected function completeMultistageIssues()
    {
        $issues = DB::connection('oldissue')->select('select * from initlaws where currentphase <> 1 and originpropid > 0');

        foreach ($issues as $issue) {
            if (! ($issue->impacttorelatedissue === "Array") && ! ($issue->impacttorelatedissue === NULL)) {

                $originalIssue = Issue::find($issue->originpropid);
                if (! $originalIssue) {
                    continue;
                }

                $toMergeimportIssuesConnectedWithIssues = explode(',', $issue->impacttorelatedissue);
                foreach ($toMergeimportIssuesConnectedWithIssues as $key => $existentIssue) {
                        try {
                            $originalIssue->issuesConnectedOfThem()->attach($existentIssue);
                            $originalIssue->issuesConnectedOfMine()->attach($existentIssue);
                        } catch (\Exception $e) {
                            print_r("Shiit! O relatie nu s-a putut importa.\n");
                        }
                }
            }
        }

        print_r("Merge-ul de relatii pentru initiative a fost incheiat cu succes.\n");
        return true;
    }

    protected function importInitiatorIssue()
    {
        $initiatorIssues = DB::connection('oldissue')->select('select propid,author from initlaws where currentphase = 1');

        foreach ($initiatorIssues as $initiatorIssue) {
            $issueConnected = Issue::find($initiatorIssue->propid);
            $connectedInitiators = explode(',', $initiatorIssue->author);

            try {
                $issueConnected->connectedInitiatorsStakeholders()->sync($connectedInitiators);
            } catch (\Exception $e) {
                print_r("Shiit! Un stakeholder nu mai exista.\n");
            }

        }

        print_r("Relatiile Initiator - Issue au fost adaugate cu succes.\n");
        return true;
    }

    protected function importIssueStakeholder()
    {
        $issueStakeholders = DB::connection('oldissue')->select('select propid,stackhlist from initlaws where currentphase = 1');

        foreach ($issueStakeholders as $issueStakeholder) {
            $issueConnected = Issue::find($issueStakeholder->propid);
            $connectedStakeholders = explode(',', $issueStakeholder->stackhlist);

            try {

                $issueConnected->connectedStakeholders()->sync($connectedStakeholders);
            } catch (\Exception $e) {
                print_r("Shiit! Un stakeholder nu mai exista.\n");
            }

        }

        print_r("Relatiile Issue - Stakeholder au fost adaugate cu succes.\n");
        return true;
    }

    protected function importIssueNews()
    {
        $issueNews = DB::connection('oldissue')->select('select propid,newslist from initlaws where currentphase = 1');

        foreach ($issueNews as $issuen) {
            $issueConnected = Issue::find($issuen->propid);
            $connectedNews = explode(',', $issuen->newslist);

            try {

                $issueConnected->connectedNews()->sync($connectedNews);
            } catch (\Exception $e) {
                print_r("Shiit! O stire nu mai exista.\n");
            }

        }

        print_r("Relatiile Issue - News au fost adaugate cu succes.\n");
        return true;
    }

    protected function importIssuesConnectedWithIssues()
    {
        $issueIssues = DB::connection('oldissue')->select('select propid,impacttorelatedissue from initlaws where currentphase = 1');

        foreach ($issueIssues as $issues) {
            if (($issues->impacttorelatedissue !== NULL)
                && ($issues->impacttorelatedissue !== "Array")) {

                $issueConnected = Issue::find($issues->propid);
                $connectedIssues = explode(',', $issues->impacttorelatedissue);

                try {

                    $issueConnected->issuesConnectedOfMine()->sync($connectedIssues);
                    $issueConnected->issuesConnectedOfThem()->sync($connectedIssues);
                } catch (\Exception $e) {
                    print_r("Shiit! O stire nu mai exista.\n");
                }
            }
        }

        print_r("Relatiile Issue - Issue au fost adaugate cu succes.\n");
        return true;
    }

    protected function importDomainIssues()
    {
        $domainIssues = DB::connection('oldissue')->select('select propid,areaid from initlaws where currentphase = 1');

        foreach ($domainIssues as $issue) {
            $issueConnected = Issue::find($issue->propid);

            try {
                $issueConnected->connectedDomains()->attach($issue->areaid);
            } catch (\Exception $e){
                print_r("Shit! O relatie nu s-a putut importa.\n");
            }
        }

        print_r("Relatiile Domains - Issue au fost adaugate cu succes.\n");
        return true;
    }

    protected function importNewsStakeholder()
    {
        $newsStakeholders = DB::connection('oldissue')->select('select id,author from relatednewsandstatments');

        foreach ($newsStakeholders as $newsStakeholder) {
            if (($newsStakeholder->author !== NULL)
                && ($newsStakeholder->author !== "Array")) {

                $stakeholderConnected = News::find($newsStakeholder->id);
                $connectedNews = explode(',', $newsStakeholder->author);

                try {

                    $stakeholderConnected->connectedStakeholders()->sync($connectedNews);
                } catch (\Exception $e) {
                    print_r("Shiit! O relatie nu s-a putut importa.\n");
                }
            }
        }

        print_r("Relatiile News - Stakeholder au fost adaugate cu succes.\n");
        return true;
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
            $this->importNews();
            $this->importLocations();
            $this->importIssues();
            $this->completeMultistageIssues();
            $this->importInitiatorIssue();
            $this->importIssueStakeholder();
            $this->importIssueNews();
            $this->importIssuesConnectedWithIssues();
            $this->importDomainIssues();
            $this->importNewsStakeholder();


            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            print_r('Shiit! Rollback happened.');
        }
    }
}
