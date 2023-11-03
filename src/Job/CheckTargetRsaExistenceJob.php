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

class CheckTargetRsaExistenceJob implements ShouldQueue
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
        $this->transfer->setStatus(TransferStatuses::TARGET_ID_RSA_EXISTENCE_CHECKING());
        $target = $this->transfer->getTarget();
        $targetServer = $target->getServer();
        $checkLocalRsa = Artisan::call('transfer:check_id_rsa', [
            'ip' => $targetServer->getIp(),
            'port' => $targetServer->getPort(),
            'username' => $targetServer->getUsername(),
            'password' => $targetServer->getPassword()
        ]);

        if ($checkLocalRsa == 0) {
            $this->transfer->setStatus(TransferStatuses::TARGET_ID_RSA_NOT_FOUND());
            return;
        } else if ($checkLocalRsa == 2) {
            $this->transfer->setStatus(TransferStatuses::TARGET_SSH_CREDENTIALS_INVALID());
            return;
        }

        $this->transfer->setStatus(TransferStatuses::TARGET_ID_RSA_FOUND());

        if ($this->callNextStep) {
            TransferRsaJob::dispatch($this->transfer);
        }
    }
}