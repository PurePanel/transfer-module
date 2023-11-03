<?php

namespace Visiosoft\TransferModule\Console\Command;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Visiosoft\TransferModule\Transfer\Helpers\SSHAgent;

class DumpSqlCommand extends Command
{
    protected $signature = 'transfer:dump_sql {source_ip} {source_port} {source_username} {source_password} {source_database} {source_database_username} {source_database_password} {dump_name} {dump_directory}';
    public const DUMP_FAILED = 0;
    public const DUMP_SUCCESS = 1;
    public const INVALID_CREDENTIALS = 2;


    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $sourceIp = $this->argument('source_ip');
        $sourcePort = $this->argument('source_port');
        $sourceUsername = $this->argument('source_username');
        $sourcePassword = $this->argument('source_password');
        $sourceDatabase = $this->argument('source_database');
        $sourceDatabaseUser = $this->argument('source_database_username');
        $sourceDatabasePassword = $this->argument('source_database_password');
        $dumpName = $this->argument('dump_name');
        $dumpDirectory = $this->argument('dump_directory');

        $sshAgent = new SSHAgent($sourceIp, $sourcePort, $sourceUsername, $sourcePassword);
        if (!$sshAgent->login()) {
            return self::INVALID_CREDENTIALS;
        }

        $dump = $sshAgent->sqlDump($sourceDatabase, $sourceDatabaseUser, $sourceDatabasePassword, $dumpName, $dumpDirectory);


        if (strlen($dump) == 0  || $this->warningPrinted($dump)) {
            return self::DUMP_SUCCESS;
        }

        return self::DUMP_FAILED;
    }

    public function warningPrinted($inputString)
    {
        $pattern = '/using a password on the command line interface can be insecure/i';
        return preg_match($pattern, $inputString) === 1;
    }
}