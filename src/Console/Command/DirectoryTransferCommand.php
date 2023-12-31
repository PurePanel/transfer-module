<?php

namespace Visiosoft\TransferModule\Console\Command;

use Illuminate\Console\Command;
use Visiosoft\TransferModule\Transfer\Helpers\SSHAgent;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class DirectoryTransferCommand extends Command
{
    protected $signature = 'transfer:directory {target_ip} {target_port} {target_username} {target_password} {target_path} {target_rsa_path} {source_ip} {source_port} {source_username} {source_directory_path}';
    public const DIRECTORY_TRANSFER_FAIL = 0;
    public const DIRECTORY_TRANSFERRED = 1;
    public const INVALID_CREDENTIALS = 2;

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $targetIp = $this->argument('target_ip');
        $targetPort = $this->argument('target_port');
        $targetUsername = $this->argument('target_username');
        $targetPassword = $this->argument('target_password');
        $targetPath = $this->argument('target_path');
        $targetRsaPath = $this->argument('target_rsa_path');
        $sourceIp = $this->argument('source_ip');
        $sourcePort = $this->argument('source_port');
        $sourceUsername = $this->argument('source_username');
        $sourcePath = $this->argument('source_directory_path');

        $sshAgent = new SSHAgent($targetIp, $targetPort, $targetUsername, $targetPassword);
        if (!$sshAgent->login()) {
            return self::INVALID_CREDENTIALS;
        }

        $sshAgent->exec($sshAgent->sudo() . " rm -rf " . $targetPath . "*");
        $sshAgent->chmod(777, $sshAgent->removeTrailingSlash($targetPath));

        $rsyncCommand = 'rsync -azu --delete --no-perms --no-times --stats -e "ssh -i ' . $targetRsaPath . ' -p ' . $sourcePort . '" ' . $sourceUsername . '@' . $sourceIp . ':' . $sourcePath . ' ' . $targetPath;

        $transfer = $sshAgent->exec($rsyncCommand);
        if (empty($transfer) || $this->checkNumberOfFiles($transfer)) {
            $sshAgent->logout();
            return self::DIRECTORY_TRANSFERRED;
        }

        $log = new Logger('directory_transfer');
        $log->pushHandler(new StreamHandler(storage_path('logs/directory_transfer.log')), Logger::ERROR);
        $log->error($transfer);
        $sshAgent->logout();
        return self::DIRECTORY_TRANSFER_FAIL;


    }

    function checkNumberOfFiles($text)
    {
        if (preg_match('/Number of files: (\d+)/', $text, $matches)) {
            $numFiles = intval($matches[1]);
            return $numFiles > 0;
        }
        return false;
    }

}
