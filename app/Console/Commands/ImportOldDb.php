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

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        DB::statement('CREATE DATABASE IF NOT EXISTS '.$this->argument('db_name'));
        print_r('Created database '.$this->argument('db_name')."\n");
        DB::statement('GRANT ALL PRIVILEGES ON *.* TO '."'".$this->argument('db_user')."'@"."'localhost' IDENTIFIED BY "."'".$this->argument('db_password')."';");
        print_r('Created user '.$this->argument('db_user').' with password '.$this->argument('db_password').' and granted all privileges to '.$this->argument('db_name')."\n");
        DB::statement('FLUSH PRIVILEGES;');

        if (App::runningInConsole())
        {
            echo exec('mysql -u '.$this->argument('db_user').' -p'.$this->argument('db_password').' '.$this->argument('db_name').' < '.base_path().'/'.$this->argument('sql_file'));
        }

        DB::beginTransaction();

        DB::connection('oldissue')->select('select * from alerts'); 

        DB::rollback();


    }
}
