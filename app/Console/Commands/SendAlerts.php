<?php

namespace Issue\Console\Commands;

use Illuminate\Console\Command;
use Issue\Alert;

class SendAlerts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'alerts:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sends Alerts to all subscribed users';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        Alert::sendAllNewsAlerts();
        Alert::sendAllIssueAlerts();
    }
}
