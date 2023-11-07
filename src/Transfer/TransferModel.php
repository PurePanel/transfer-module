<?php namespace Visiosoft\TransferModule\Transfer;

use Visiosoft\SiteModule\Site\SiteModel;
use Visiosoft\TransferModule\Transfer\Contract\TransferInterface;
use Anomaly\Streams\Platform\Model\Transfer\TransferTransfersEntryModel;
use Visiosoft\TransferModule\Transfer\Helpers\TransferStatuses;

class TransferModel extends TransferTransfersEntryModel implements TransferInterface
{

    /**
     * @return string
     */
    public function getSourceIp(): string
    {
        return $this->source_ip;
    }

    /**
     * @return int
     */
    public function getSourcePort(): int
    {
        return $this->source_port ?? 22;
    }

    /**
     * @return string
     */
    public function getSourceUsername(): string
    {
        return $this->source_username;
    }

    /**
     * @return string
     */
    public function getSourcePassword(): string
    {
        return $this->source_password;
    }

    public function getTransferDatabase()
    {
        return $this->transfer_database;
    }

    public function getSourceDatabase(): string
    {
        return $this->source_database;
    }

    /**
     * @return string
     */
    public function getSourceDatabaseUser(): string
    {
        return $this->source_database_user;
    }

    /**
     * @return string
     */
    public function getSourceDatabasePassword(): string
    {
        return $this->source_database_password;
    }

    public function getSourceDirectoryPath(): string
    {
        return $this->source_directory_path.'/';
    }

    /**
     * @return SiteModel
     */
    public function getTarget(): SiteModel
    {
        return SiteModel::withTrashed()->find($this->target_id);
    }

    public function getSqlDumpName(): string
    {
        return $this->getTarget()->getSiteID() . ".sql";
    }

    /**
     * @return string|null
     */
    public function getStatus(): ?string
    {
        $transferStatus = new TransferStatuses($this->status);
        return $transferStatus->getKey();
    }

    /**
     * @param TransferStatuses $transferStatuses
     * @return void
     */
    public function setStatus(TransferStatuses $transferStatuses): void
    {
        $this->update(['status' => $transferStatuses->getValue()]);
    }

}
