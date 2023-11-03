<?php

namespace Visiosoft\TransferModule\Job;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Visiosoft\TransferModule\Transfer\Helpers\TransferStatuses;
use Visiosoft\TransferModule\Transfer\Contract\TransferRepositoryInterface;
use Visiosoft\TransferModule\Transfer\Helpers\SSHAgent;
use Visiosoft\TransferModule\Transfer\TransferModel;

class CheckLoginWithRsaJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private TransferModel $transfer;
    private bool $isInitial;
    private bool $callNextStep;
    private TransferRepositoryInterface $transferRepository;

    public $tries = 1;

    public function __construct(TransferModel $transfer, bool $isInitial = true, $callNextStep = true)
    {
        $this->transfer = $transfer;
        $this->isInitial = $isInitial;
        $this->callNextStep = $callNextStep;
    }

    public function handle()
    {
        $this->transfer->setStatus(TransferStatuses::LOGIN_WITH_RSA_CHECKING());
        $target = $this->transfer->getTarget();
        $targetServer = $target->getServer();
        $sshAgent = new SSHAgent($targetServer->getIp(), $targetServer->getPort(), $targetServer->getUsername(), $targetServer->getPassword());

        if (!$sshAgent->login()) {
            $this->transfer->setStatus(TransferStatuses::TARGET_SSH_CREDENTIALS_INVALID());
            return;
        }
        $sshAgent->logout();

        $rsyncTestCommand = 'rsync -e "ssh -o StrictHostKeyChecking=no -i ' . $targetServer->getRsaPath() . ' -p ' . $this->transfer->getSourcePort() . '" ' . $this->transfer->getSourceUsername() . '@' . $this->transfer->getSourceIp() . ':' . $this->transfer->getSourceDirectoryPath() . ' ' . $target->getDirectoryPath();

        if ($this->isSkippingDirectory($sshAgent->exec($rsyncTestCommand))) {
            $this->transfer->setStatus(TransferStatuses::LOGIN_WITH_RSA_SUCCESS());
            if ($this->transfer->getTransferDatabase()) {
                DumpSqlJob::dispatch($this->transfer);
            } else {
                DirectoryTransferJob::dispatch($this->transfer);
            }
        } else {
            $this->transfer->setStatus(TransferStatuses::LOGIN_WITH_RSA_FAILED());
            if ($this->callNextStep && $this->isInitial) {
                CheckTargetRsaExistenceJob::dispatch($this->transfer);
            }
        }

    }

    private function isSkippingDirectory($inputString): bool
    {
        $pattern = '/skipping directory/i';
        return preg_match($pattern, $inputString) === 1;
    }
}