<?php

namespace Issue\Console\Commands;

use DB;
use App;
use File;
use Issue\News;
use Issue\User;
use Issue\Issue;
use Issue\Domain;
use Issue\Document;
use Issue\FlowStep;
use Issue\Location;
use Issue\Stakeholder;
use Issue\LocationStep;
use Issue\UploadedFile;
use Issue\StepAutocomplete;
use Illuminate\Console\Command;

class ImportOldDb extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:database';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Imports old database set in \Config\database.php';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
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

            if ($issue->issuestatus === 'INPROGRESS') {
                $newIssue->phase = 'curent';
            } elseif ($issue->issuestatus === 'REFERRED_BACK' || $issue->issuestatus === 'ARCHIVED') {
                $newIssue->phase = 'arhivatRespinsSauAbrogat';
            } elseif ($issue->issuestatus === 'ENDSTAGE' || $issue->issuestatus === 'COMPLETE') {
                $newIssue->phase = 'publicatMO';
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

    private function explodeImpactToRelatedIssue($issue, $originalIssue)
    {
        $toMergeimportIssuesConnectedWithIssues = explode(',', $issue->impacttorelatedissue);
        foreach ($toMergeimportIssuesConnectedWithIssues as $key => $existentIssue) {
                try {
                    $originalIssue->issuesConnectedOfThem()->attach($existentIssue);
                    $originalIssue->issuesConnectedOfMine()->attach($existentIssue);
                } catch (\Exception $e) {
                    print_r("Shiit! O relatie nu s-a putut importa.\n");
                }
        }

        return true;
    }

    protected function completeMultistageIssuesConnected()
    {
        $allIssues = DB::connection('oldissue')->select('select * from initlaws');
        $issues = DB::connection('oldissue')->select('select * from initlaws where currentphase <> 1 and originpropid > 0');

        foreach ($issues as $issue) {
            if (($issue->impacttorelatedissue === "Array")
                && ($issue->impacttorelatedissue === NULL)) {
                    continue;
            }


            if ($issue->currentphase == 2) {
                $originalIssue = Issue::find($issue->originpropid);
                if (! $originalIssue) {
                    continue;
                }
                $this->explodeImpactToRelatedIssue($issue, $originalIssue);
            }

            if ($issue->currentphase == 3) {
                $intermediateIssue = $issue->originpropid;

                foreach ($allIssues as $allIssue) {
                    if ($allIssue->propid == $intermediateIssue
                        && $allIssue->originpropid > 0) {
                        $getOriginalIssue = $allIssue->originpropid;

                        foreach ($allIssues as $origIssue) {
                            if ($origIssue->propid == $getOriginalIssue) {
                                $first = Issue::find($origIssue->propid);
                                if (! $first) {
                                    continue;
                                }
                                $this->explodeImpactToRelatedIssue($issue, $first);
                            }
                        }
                    }
                }
            }
        }

        print_r("Merge-ul de relatii pentru initiative a fost incheiat cu succes.\n");
        return true;
    }

    private function initiatorIssue($initiatorIssue, $issueConnected)
    {
        $connectedInitiators = explode(',', $initiatorIssue->author);

        try {
            $issueConnected->connectedInitiatorsStakeholders()->attach($connectedInitiators);
        } catch (\Exception $e) {
            print_r("Shiit! Un stakeholder nu mai exista.\n");
        }

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

    protected function completeMultistageInitiatorIssues()
    {
        $allIssues = DB::connection('oldissue')->select('select * from initlaws');
        $issues = DB::connection('oldissue')->select('select * from initlaws where currentphase <> 1 and originpropid > 0');

        foreach ($issues as $issue) {
            if (($issue->author === "Array")
                && ($issue->author === NULL)) {
                    continue;
            }


            if ($issue->currentphase == 2) {
                $originalIssue = Issue::find($issue->originpropid);
                if (! $originalIssue) {
                    continue;
                }
                $this->initiatorIssue($issue, $originalIssue);
            }

            if ($issue->currentphase == 3) {
                $intermediateIssue = $issue->originpropid;

                foreach ($allIssues as $allIssue) {
                    if ($allIssue->propid == $intermediateIssue
                        && $allIssue->originpropid > 0) {
                        $getOriginalIssue = $allIssue->originpropid;

                        foreach ($allIssues as $origIssue) {
                            if ($origIssue->propid == $getOriginalIssue) {
                                $first = Issue::find($origIssue->propid);
                                if (! $first) {
                                    continue;
                                }
                                $this->initiatorIssue($issue, $first);
                            }
                        }
                    }
                }
            }
        }

        print_r("Completarea de relatii pentru InitiatorIssue a fost incheiat cu succes.\n");
        return true;
    }

    private function explodeIssueStakeholder($issueStakeholder, $issueConnected)
    {
        $connectedStakeholders = explode(',', $issueStakeholder->stackhlist);

        try {

            $issueConnected->connectedStakeholders()->attach($connectedStakeholders);
        } catch (\Exception $e) {
            print_r("Shiit! Un stakeholder nu mai exista.\n");
        }

        return true;
    }

    protected function completeMultistageIssueStakeholder()
    {
        $allIssues = DB::connection('oldissue')->select('select * from initlaws');
        $issues = DB::connection('oldissue')->select('select * from initlaws where currentphase <> 1 and originpropid > 0');

        foreach ($issues as $issue) {
            if (($issue->stackhlist === "Array")
                && ($issue->stackhlist === NULL)) {
                    continue;
            }


            if ($issue->currentphase == 2) {
                $originalIssue = Issue::find($issue->originpropid);
                if (! $originalIssue) {
                    continue;
                }
                $this->explodeIssueStakeholder($issue, $originalIssue);
            }

            if ($issue->currentphase == 3) {
                $intermediateIssue = $issue->originpropid;

                foreach ($allIssues as $allIssue) {
                    if ($allIssue->propid == $intermediateIssue
                        && $allIssue->originpropid > 0) {
                        $getOriginalIssue = $allIssue->originpropid;

                        foreach ($allIssues as $origIssue) {
                            if ($origIssue->propid == $getOriginalIssue) {
                                $first = Issue::find($origIssue->propid);
                                if (! $first) {
                                    continue;
                                }
                                $this->explodeIssueStakeholder($issue, $first);
                            }
                        }
                    }
                }
            }
        }

        print_r("Completarea de relatii pentru IssueStakeholder a fost incheiat cu succes.\n");
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

    private function explodeIssueNews($issuen, $issueConnected)
    {
        $connectedNews = explode(',', $issuen->newslist);

        try {

            $issueConnected->connectedNews()->attach($connectedNews);
        } catch (\Exception $e) {
            print_r("Shiit! O stire nu mai exista.\n");
        }

        return true;
    }

    protected function completeMultistageIssueNews()
    {
        $allIssues = DB::connection('oldissue')->select('select * from initlaws');
        $issues = DB::connection('oldissue')->select('select * from initlaws where currentphase <> 1 and originpropid > 0');

        foreach ($issues as $issue) {
            if (($issue->newslist === "Array")
                && ($issue->newslist === NULL)) {
                    continue;
            }


            if ($issue->currentphase == 2) {
                $originalIssue = Issue::find($issue->originpropid);
                if (! $originalIssue) {
                    continue;
                }
                $this->explodeIssueNews($issue, $originalIssue);
            }

            if ($issue->currentphase == 3) {
                $intermediateIssue = $issue->originpropid;

                foreach ($allIssues as $allIssue) {
                    if ($allIssue->propid == $intermediateIssue
                        && $allIssue->originpropid > 0) {
                        $getOriginalIssue = $allIssue->originpropid;

                        foreach ($allIssues as $origIssue) {
                            if ($origIssue->propid == $getOriginalIssue) {
                                $first = Issue::find($origIssue->propid);
                                if (! $first) {
                                    continue;
                                }
                                $this->explodeIssueNews($issue, $first);
                            }
                        }
                    }
                }
            }
        }

        print_r("Completarea de relatii pentru IssueNews a fost incheiat cu succes.\n");
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

    protected function importLocationSteps()
    {
        $issues = Issue::all();

        foreach ($issues as $issue) {
            $count = 0;
            $importSteps = DB::connection('oldissue')->select("select * from customsteps where marckfordelete = 0 and propid = {$issue->id} order by id asc");

            if (empty($importSteps)) {
                continue;
            }

            $newLocationStep = new LocationStep;

            if (isset($importSteps[0]->optionlocation) && $importSteps[0]->optionlocation == 1) {
                    $newLocationStep->location_id = 3;
            } elseif (isset($importSteps[0]->optionlocation) && $importSteps[0]->optionlocation == 2) {
                    $newLocationStep->location_id = 4;
            } elseif ($importSteps[0]->lextypeid == 3 || $importSteps[0]->lextypeid == 4 || $importSteps[0]->lextypeid == 5) {
                    $newLocationStep->location_id = 5;
            } else {
                $newLocationStep->location_id = 2;
            }

            $newLocationStep->issue_id = $issue->id;
            $newLocationStep->step_order = 1;

            $newLocationStep->save();

            foreach ($importSteps as $importStep) {
                $newFlowStep = new FlowStep;
                $newFlowStep->id = $importStep->id;
                $newFlowStep->flow_name = StepAutocomplete::find($importStep->basestepid)->name;
                $newFlowStep->estimated_duration = $importStep->durata ? $importStep->durata : '';
                $newFlowStep->location_step_id = $newLocationStep->id;
                $newFlowStep->flowstep_order = $count++;
                $newFlowStep->start_date = $importStep->dataStart;
                $newFlowStep->end_date = $importStep->dataEnd;
                $newFlowStep->finalizat = $importStep->dataEnd ? 1 : 0;

                $translatableData = [
                    'ro' =>[
                        'observatii' => $importStep->obsv ? $importStep->obsv : '',
                    ],
                    'en' => [
                        'observatii' => $importStep->enobsv ? $importStep->enobsv : '',
                    ]
                ];

                $newFlowStep->fill($translatableData);
                $newFlowStep->save();
            }
        }

        print_r("Au fost importati: ".LocationStep::count()." locationSteps \n cu ".FlowStep::count()." flowSteps.");
        return true;
    }

    protected function importLocationStepsForContinuedIssues()
    {
        $issues = DB::connection('oldissue')->select('select * from initlaws where currentphase <> 1 and originpropid > 0');
        foreach ($issues as $issue) {
            $count = 0;
            $importSteps = DB::connection('oldissue')->select("select * from customsteps where marckfordelete = 0 and propid = {$issue->propid} order by id asc");

            if (empty($importSteps)) {
                continue;
            }

            $newLocationStep = new LocationStep;

            if (isset($importSteps[0]->optionlocation) && $importSteps[0]->optionlocation == 1) {
                    $newLocationStep->location_id = 3;
            } elseif (isset($importSteps[0]->optionlocation) && $importSteps[0]->optionlocation == 2) {
                    $newLocationStep->location_id = 4;
            } elseif ($importSteps[0]->lextypeid == 3 || $importSteps[0]->lextypeid == 4 || $importSteps[0]->lextypeid == 5) {
                    $newLocationStep->location_id = 5;
            } else {
                $newLocationStep->location_id = 2;
            }

            $newLocationStep->issue_id = $issue->originpropid;
            $newLocationStep->step_order = 1;

            $newLocationStep->save();

            foreach ($importSteps as $importStep) {
                $newFlowStep = new FlowStep;
                $newFlowStep->id = $importStep->id;
                $newFlowStep->flow_name = StepAutocomplete::find($importStep->basestepid)->name;
                $newFlowStep->estimated_duration = $importStep->durata ? $importStep->durata : '';
                $newFlowStep->location_step_id = $newLocationStep->id;
                $newFlowStep->flowstep_order = $count++;
                $newFlowStep->start_date = $importStep->dataStart;
                $newFlowStep->end_date = $importStep->dataEnd;
                $newFlowStep->finalizat = $importStep->dataEnd ? 1 : 0;

                $translatableData = [
                    'ro' =>[
                        'observatii' => $importStep->obsv ? $importStep->obsv : '',
                    ],
                    'en' => [
                        'observatii' => $importStep->enobsv ? $importStep->enobsv : '',
                    ]
                ];

                $newFlowStep->fill($translatableData);
                $newFlowStep->save();
            }
        }
        print_r("Au fost importati: ".LocationStep::count()." locationSteps \n cu ".FlowStep::count()." flowSteps.");
        return true;
    }

    private function moveFile($location, $newName)
    {
        return File::copy($location, storage_path().'/documents/'.$newName);
    }

    protected function importDocuments()
    {
        $allFiles = [];
        $pathToFiles = sprintf('%s/var/www/andr_v2/uploads/reldocs', storage_path());

        $oldDocuments = DB::connection('oldissue')->select('select * from relateddoc
            where propid > 120 and stepid <> 0
        ');

        foreach ($oldDocuments as $document) {
            if (! $document->filepaths) {
                continue;
            }

            if (! Issue::find($document->propid)) {
                continue;
            }

            $documentPath = sprintf('%s/propid_%s/stepid_%s/',
                                $pathToFiles,
                                $document->propid,
                                $document->stepid
                            );

            try {
                $getFileNamesFromFolder = array_diff(scandir($documentPath), ['.', '..']);

                if (! $getFileNamesFromFolder) {
                    continue;
                }

                foreach ($getFileNamesFromFolder as $file) {

                    if (! $file) {
                        continue;
                    }

                    if (in_array($file, $allFiles)) {
                        continue;
                    }

                    $allFiles[] = $file;

                    $fullPathToFile = sprintf('%s%s', $documentPath, $file);

                    do {
                        $randomName = str_random(40);
                    } while (UploadedFile::where('file_name', $randomName)->count() > 0);

                    do {
                        $codPublic = str_random(40);
                    } while (Document::where('public_code', $codPublic)->count() > 0);

                    $uploadedFileData = [
                        'file_name' => $randomName,
                        'folder' => '/documents/',
                        'original_file_name' => $file,
                    ];

                    $this->moveFile($fullPathToFile, $uploadedFileData['file_name']);

                    $doc = factory(Document::class)->create([
                        'public' => 1,
                        'uploaded_file_id' => factory(UploadedFile::class)
                            ->create(
                                    $uploadedFileData
                                )->id,
                        'public_code' => $codPublic,
                        'init_at' => $document->initat,
                    ]);

                    $translatableData = [
                        'ro' =>[
                            'title' => $document->content ? $document->content : '',
                        ],
                        'en' => [
                            'title' => $document->encontent ? $document->encontent : '',
                        ]
                    ];
                    $doc->fill($translatableData);
                    $doc->save();

                    try {
                        $doc->steps()->attach($document->stepid);
                    } catch (\Exception $e) {
                        print_r("Shiit! O relatie Document - FlowStep nu s-a putut importa.\n");
                    }

                }
            } catch (\Exception $e) {
                print_r("Shiit! Un folder nu exista.\n");
            }
        }


        echo sprintf("Au fost importate %s documente.\n", Document::count());
        return true;
    }

    protected function importRemainingDocuments()
    {
        $initDocuments = Document::count();
        $lostDocuments = [];
        $documentsForExtendedIssues = [];
        $pathToFiles = sprintf('%s/var/www/andr_v2/uploads/reldocs/propid_/stepid_', storage_path());

        $dbPathToFile = '/var/www/andr_v2/uploads/reldocs/propid_/stepid_/';

        $oldDocuments = DB::connection('oldissue')->select('select * from relateddoc
            where propid > 120 and stepid <> 0
        ');

        $getFileNamesFromFolder = array_diff(scandir($pathToFiles), ['.', '..']);


        foreach ($oldDocuments as $document) {
            if (! $document->filepaths) {
                continue;
            }

            if (strpos($document->filepaths, $dbPathToFile) === 0) {
              $lostDocuments[] = $document;
            }
        }

        foreach ($lostDocuments as $document) {
            $fullPathToFile = $document->filepaths;
            $file = str_replace($dbPathToFile, '', $fullPathToFile);

            if (! in_array($file, $getFileNamesFromFolder)) {
                continue;
            }

            do {
                $randomName = str_random(40);
            } while (UploadedFile::where('file_name', $randomName)->count() > 0);

            do {
                $codPublic = str_random(40);
            } while (Document::where('public_code', $codPublic)->count() > 0);

            $uploadedFileData = [
                        'file_name' => $randomName,
                        'folder' => '/documents/',
                        'original_file_name' => $file,
                    ];

            $this->moveFile(storage_path().$fullPathToFile, $uploadedFileData['file_name']);

            $doc = factory(Document::class)->create([
                'public' => 1,
                'uploaded_file_id' => factory(UploadedFile::class)
                    ->create(
                            $uploadedFileData
                        )->id,
                'public_code' => $codPublic,
                'init_at' => $document->initat,
            ]);

            $translatableData = [
                'ro' =>[
                    'title' => $document->content ? $document->content : '',
                ],
                'en' => [
                    'title' => $document->encontent ? $document->encontent : '',
                ]
            ];
            $doc->fill($translatableData);
            $doc->save();

            try {
                $doc->steps()->attach($document->stepid);
            } catch (\Exception $e) {
                print_r("Shiit! O relatie Document - FlowStep nu s-a putut importa.\n");
            }
        }

        echo sprintf("Au fost recuperate %s documente salvate la comun intr-un folder.\n",
            $count = Document::count() - $initDocuments);
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

            $this->importUsers();
            $this->importStepAutocompletes();
            $this->importStakeholders();
            $this->importDomains();
            $this->importNews();
            $this->importLocations();
            $this->importIssues();
            $this->importIssuesConnectedWithIssues();
            $this->importInitiatorIssue();
            $this->importIssueStakeholder();
            $this->importIssueNews();
            $this->importDomainIssues();
            $this->completeMultistageIssuesConnected();
            $this->completeMultistageInitiatorIssues();
            $this->completeMultistageIssueStakeholder();
            $this->completeMultistageIssueNews();
            $this->importNewsStakeholder();
            $this->importLocationSteps();
            $this->importLocationStepsForContinuedIssues();
            $this->importDocuments();
            $this->importRemainingDocuments();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            print_r('Shiit! Rollback happened.');
        }
    }
}
