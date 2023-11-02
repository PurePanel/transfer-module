<?php

namespace Visiosoft\TransferModule\Console\Command;

use Illuminate\Console\Command;
use Visiosoft\TransferModule\Transfer\Helpers\SSHAgent;

class TransferIdRsaCommand extends Command
{
    protected $signature = 'transfer:transfer_id_rsa {target_ip} {target_port} {target_username} {target_password} {source_ip} {source_port} {source_username} {source_password}';

    public const TARGET_SSH_CREDENTIALS_INVALID = 0;
    public const TRANSFER_SUCCESS = 1;
    public const SOURCE_SSH_CREDENTIALS_INVALID = 2;

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
        $sourceIp = $this->argument('source_ip');
        $sourcePort = $this->argument('source_port');
        $sourceUsername = $this->argument('source_username');
        $sourcePassword = $this->argument('source_password');


        $targetAgent = new SSHAgent($targetIp, $targetPort, $targetUsername, $targetPassword);

        if (!$targetAgent->login()) {
            return self::TARGET_SSH_CREDENTIALS_INVALID;
        }

        $targetRsaPub = $targetAgent->getIdRsaPub();
        $targetAgent->logout();

        $sourceAgent = new SSHAgent($sourceIp, $sourcePort, $sourceUsername, $sourcePassword);
        if (!$sourceAgent->login()) {
            return self::SOURCE_SSH_CREDENTIALS_INVALID;
        }

        $sourceAgent->copyRsa($targetRsaPub);
        $sourceAgent->logout();

        return self::TRANSFER_SUCCESS;


    }
}