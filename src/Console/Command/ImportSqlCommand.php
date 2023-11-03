<?php

namespace Visiosoft\TransferModule\Console\Command;

use Illuminate\Console\Command;
use Visiosoft\TransferModule\Transfer\Helpers\SSHAgent;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class ImportSqlCommand extends Command
{
    protected $signature = 'transfer:import_sql {ip} {port} {username} {password} {database} {database_user} {database_password} {dump_path}';
    public const DUMP_FAILED = 0;
    public const DUMP_SUCCESS = 1;
    public const INVALID_CREDENTIALS = 2;


    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $sourceIp = $this->argument('ip');
        $sourcePort = $this->argument('port');
        $sourceUsername = $this->argument('username');
        $sourcePassword = $this->argument('password');
        $sourceDatabase = $this->argument('database');
        $sourceDatabaseUser = $this->argument('database_user');
        $sourceDatabasePassword = $this->argument('database_password');
        $dumpPath = $this->argument('dump_path');

        $sshAgent = new SSHAgent($sourceIp, $sourcePort, $sourceUsername, $sourcePassword);

        if (!$sshAgent->login()) {
            return self::INVALID_CREDENTIALS;
        }

        $import = $sshAgent->sqlImport($sourceDatabase, $sourceDatabaseUser, $sourceDatabasePassword, $dumpPath);

        if (empty($import) || $this->isPasswordInsecure($import)) {
            return self::DUMP_SUCCESS;
        }

        $log = new Logger('sql_transfer');
        $log->pushHandler(new StreamHandler(storage_path('logs/sql_transfer.log')), Logger::ERROR);
        $log->error($import);

        return self::DUMP_FAILED;
    }

    function isPasswordInsecure($inputString): bool
    {
        $pattern = '/Using a password on the command line interface can be insecure/i';
        return preg_match($pattern, $inputString) === 1;
    }
}