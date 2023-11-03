<?php

namespace Visiosoft\TransferModule\Job;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Artisan;
use Visiosoft\TransferModule\Transfer\Contract\TransferRepositoryInterface;
use Visiosoft\TransferModule\Transfer\Helpers\TransferStatuses;
use Visiosoft\TransferModule\Transfer\TransferModel;

class ImportSqlJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private TransferModel $transfer;
    private bool $callNextStep;

    public $timeout = 0;

    public $tries = 1;

    public function __construct(TransferModel $transfer, $callNextStep = true)
    {
        $this->transfer = $transfer;
        $this->callNextStep = $callNextStep;
        $this->transferRepository = app(TransferRepositoryInterface::class);
    }

    public function handle()
    {
        $this->transfer->setStatus(TransferStatuses::SQL_IMPORT_STARTED());
        $target = $this->transfer->getTarget();
        $targetServer = $target->getServer();
        $importSql = Artisan::call('transfer:import_sql',
            [
                'ip' => $targetServer->getIp(),
                'port' => $targetServer->getPort(),
                'username' => $target->getUsername(),
                'password' => $target->getPassword(),
                'database' => $target->getUsername(),
                'database_user' => $target->getUsername(),
                'database_password' => $target->getDatabasePassword(),
                'dump_path' => $target->getDirectoryPath() . $this->transfer->getSqlDumpName()
            ]);

        if ($importSql == 0) {
            $this->transfer->setStatus(TransferStatuses::SQL_IMPORT_FAILED());
            return;
        } else if ($importSql == 2) {
            $this->transfer->setStatus(TransferStatuses::SOURCE_SQL_CREDENTIALS_INVALID());
            return;
        }

        $this->transfer->setStatus(TransferStatuses::SQL_IMPORTED());

        if ($this->callNextStep) {
            $this->transfer->setStatus(TransferStatuses::TRANSFER_COMPLETED());
        }
    }
}