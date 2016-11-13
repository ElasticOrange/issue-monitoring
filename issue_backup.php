<?php

require 'vendor/autoload.php';

function out($message) {
    echo "\n$message\n";
}

Dotenv::load(__DIR__);

$backup_directory_today = "/backup/". date('Y-m-d');
mkdir($backup_directory_today);

$issue_database_filename = $backup_directory_today ."/issue_database.sql.gz";

// Archive Lendia database
$db_host = getenv('DB_HOST');
$db_database = getenv('DB_DATABASE');
$db_user = getenv('DB_USERNAME');
$db_pass = getenv('DB_PASSWORD');

$dump_command = "mysqldump --host={$db_host} --user={$db_user} --password={$db_pass} {$db_database} | gzip > {$issue_database_filename}";

out("Running Issue database backup");
out($dump_command);
exec($dump_command);
