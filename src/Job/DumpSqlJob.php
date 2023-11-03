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

class DumpSqlJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private TransferModel $transfer;
    private bool $callNextStep;
    private TransferRepositoryInterface $transferRepository;

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
        $this->transfer->setStatus(TransferStatuses::SQL_DUMP_STARTED());
        $dumpSql = Artisan::call('transfer:dump_sql',
            [
                'source_ip' => $this->transfer->getSourceIp(),
                'source_port' => $this->transfer->getSourcePort(),
                'source_username' => $this->transfer->getSourceUsername(),
                'source_password' => $this->transfer->getSourcePassword(),
                'source_database' => $this->transfer->getSourceDatabase(),
                'source_database_username' => $this->transfer->getSourceDatabaseUser(),
                'source_database_password' => $this->transfer->getSourceDatabasePassword(),
                'dump_name' => $this->transfer->getSqlDumpName(),
                'dump_directory' => $this->transfer->getSourceDirectoryPath()

            ]);

        if ($dumpSql == 0) {
            $this->transfer->setStatus(TransferStatuses::SQL_DUMP_FAILED());
            return;
        } else if ($dumpSql == 2) {
            $this->transfer->setStatus(TransferStatuses::SOURCE_SQL_CREDENTIALS_INVALID());
            return;
        }

        $this->transfer->setStatus(TransferStatuses::SQL_DUMP_SUCCESS());

        if ($this->callNextStep) {
            DirectoryTransferJob::dispatch($this->transfer);
        }


    }
}