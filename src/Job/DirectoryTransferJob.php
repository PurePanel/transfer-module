<?php

namespace Visiosoft\TransferModule\Job;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Artisan;
use Visiosoft\TransferModule\Transfer\Helpers\TransferStatuses;
use Visiosoft\TransferModule\Transfer\TransferModel;

class DirectoryTransferJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private TransferModel $transfer;
    private bool $callNextStep;

    public function __construct(TransferModel $transfer, $callNextStep = true)
    {
        $this->transfer = $transfer;
        $this->callNextStep = $callNextStep;
    }

    public function handle()
    {
        $this->transfer->setStatus(TransferStatuses::DIRECTORY_TRANSFER_STARTED());
        $target = $this->transfer->getTarget();
        $targetServer = $target->getServer();

        $directoryTransfer = Artisan::call('transfer:directory',
            [
                'target_ip' => $targetServer->getIp(),
                'target_port' => $targetServer->getPort(),
                'target_username' => $targetServer->getUsername(),
                'target_password' => $targetServer->getPassword(),
                'target_rsa_path' => $targetServer->getRsaPath(),
                'target_path' => $target->getDirectoryPath(),
                'source_ip' => $this->transfer->getSourceIp(),
                'source_port' => $this->transfer->getSourcePort(),
                'source_username' => $this->transfer->getSourceUsername(),
                'source_directory_path' => $this->transfer->getSourceDirectoryPath(),
            ]
        );

        if ($directoryTransfer == 0) {
            $this->transfer->setStatus(TransferStatuses::DIRECTORY_TRANSFER_FAILED());
            return;
        } else if ($directoryTransfer == 2) {
            $this->transfer->setStatus(TransferStatuses::TARGET_SSH_CREDENTIALS_INVALID());
            return;
        }

        $this->transfer->setStatus(TransferStatuses::DIRECTORY_TRANSFERRED());

        if ($this->callNextStep) {
            ImportSqlJob::dispatch($this->transfer);
        }
    }
}