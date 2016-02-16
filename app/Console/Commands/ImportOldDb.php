<?php

namespace Issue\Console\Commands;

use Illuminate\Console\Command;
use DB;
use App;

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

        return print_r('Database succesfully imported');
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

        // DB::connection('oldissue')->select('select * from alerts'); 

        DB::rollback();
    }
}
