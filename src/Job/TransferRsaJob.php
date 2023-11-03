<?php

namespace Visiosoft\TransferModule\Job;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Artisan;
use Visiosoft\TransferModule\Transfer\Helpers\TransferStatuses;
use Visiosoft\TransferModule\Transfer\Contract\TransferRepositoryInterface;
use Visiosoft\TransferModule\Transfer\TransferModel;

class TransferRsaJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private TransferModel $transfer;
    private bool $callNextStep;
    private TransferRepositoryInterface $transferRepository;

    public $tries = 1;
    public function __construct(TransferModel $transfer, $callNextStep = true)
    {
        $this->transfer = $transfer;
        $this->callNextStep = $callNextStep;
    }

    public function handle()
    {
        $this->transfer->setStatus(TransferStatuses::ID_RSA_TRANSFER_STARTED());
        $target = $this->transfer->getTarget();
        $targetServer = $target->getServer();
        $transferRsa = Artisan::call('transfer:transfer_id_rsa', [
            'target_ip' => $targetServer->getIp(),
            'target_port' => $targetServer->getPort(),
            'target_username' => $targetServer->getUsername(),
            'target_password' => $targetServer->getPassword(),
            'source_ip' => $this->transfer->getSourceIp(),
            'source_port' => $this->transfer->getSourcePort(),
            'source_username' => $this->transfer->getSourceUsername(),
            'source_password' => $this->transfer->getSourcePassword(),
        ]);

        if ($transferRsa == 0) {
            $this->transfer->setStatus(TransferStatuses::TARGET_SSH_CREDENTIALS_INVALID());
            return;
        } else if ($transferRsa == 2) {
            $this->transfer->setStatus(TransferStatuses::SOURCE_SSH_CREDENTIALS_INVALID());
            return;
        }

        $this->transfer->setStatus(TransferStatuses::ID_RSA_TRANSFERRED());

        if ($this->callNextStep) {
            CheckLoginWithRsaJob::dispatch($this->transfer, false);
        }
    }
}