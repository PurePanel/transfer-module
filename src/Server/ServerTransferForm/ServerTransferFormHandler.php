<?php namespace Visiosoft\TransferModule\Server\ServerTransferForm;


use Anomaly\Streams\Platform\Message\MessageBag;
use Carbon\Carbon;
use Visiosoft\SiteModule\Site\Contract\SiteRepositoryInterface;
use Visiosoft\TransferModule\Console\Command\StartTransfer;
use Visiosoft\TransferModule\Job\CheckLoginWithRsaJob;
use Visiosoft\TransferModule\Server\Contract\ServerRepositoryInterface;
use Visiosoft\TransferModule\Transfer\Contract\TransferRepositoryInterface;
use Visiosoft\TransferModule\Transfer\Helpers\TransferStatuses;

class ServerTransferFormHandler
{
    public function handle(
        ServerTransferFormBuilder   $builder,
        ServerRepositoryInterface   $serverRepository,
        SiteRepositoryInterface     $siteRepository,
        TransferRepositoryInterface $transferRepository,
        MessageBag                  $messages
    )
    {
        if (!$builder->canSave()) {
            return;
        }

        if (!$server = $serverRepository->find($builder->getPostValue('server'))) {
            $messages->error(trans('visiosoft.module.transfer::message.not_found', ['name' => 'Server']));
            return;
        }

        if (!$site = $siteRepository->find($builder->getPostValue('target_site'))) {
            $messages->error(trans('visiosoft.module.transfer::message.not_found', ['name' => 'Site']));
            return;
        }

        $username = $builder->getPostValue('username');
        $databaseName = $builder->getPostValue('database_name');

        if ($builder->getForm()->getMode() == "create") {

            $transferEntry = $transferRepository->create([
                'name' => $server->getServerName() . "-" . $username . "-" . Carbon::now()->timezone('Europe/Istanbul')->format('Y-m-d H:i:s'),
                'target_id' => $site->getId(),
                'source_ip' => $server->getServerIP(),
                'source_port' => $server->getServerSSHPort(),
                'source_username' => $server->getServerSSHUsername(),
                'source_password' => $server->getServerSSHPassword(),
                'source_directory_path' => str_replace('%username%', $username, $server->getDirectorySchema()),
                'transfer_database' => true,
                'source_database' => $databaseName,
                'source_database_user' => $server->getServerDatabaseRootUsername(),
                'source_database_password' => $server->getServerDatabaseRootPassword(),
            ]);

            $transferEntry->setStatus(TransferStatuses::TRANSFER_STARTING());
            CheckLoginWithRsaJob::dispatch($transferEntry);
        }
    }
}
