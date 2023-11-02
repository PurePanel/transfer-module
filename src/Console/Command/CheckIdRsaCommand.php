<?php

namespace Visiosoft\TransferModule\Console\Command;

use Illuminate\Console\Command;
use Visiosoft\TransferModule\Transfer\Helpers\SSHAgent;

class CheckIdRsaCommand extends Command
{
    protected $signature = 'transfer:check_id_rsa {ip} {port} {username} {password}';
    public const HAS_NOT_RSA = 0;
    public const HAS_RSA = 1;
    public const SSH_CREDENTIALS_INVALID = 2;


    public function handle(): int
    {
        $sshAgent = new SSHAgent($this->argument('ip'), $this->argument('port'), $this->argument('username'), $this->argument('password'));

        if (!$sshAgent->login()) {
            return self::SSH_CREDENTIALS_INVALID;
        }

        $rsa = $sshAgent->checkIdRsaExistence();

        if (!$rsa) {
            $sshAgent->logout();
            return self::HAS_NOT_RSA;
        }

        $sshAgent->logout();

        return self::HAS_RSA;

    }
}