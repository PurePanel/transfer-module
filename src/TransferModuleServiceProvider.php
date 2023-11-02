<?php namespace Visiosoft\TransferModule;

use Anomaly\Streams\Platform\Addon\AddonServiceProvider;
use Visiosoft\TransferModule\Console\Command\CheckIdRsaCommand;
use Visiosoft\TransferModule\Console\Command\DirectoryTransferCommand;
use Visiosoft\TransferModule\Console\Command\DumpSqlCommand;
use Visiosoft\TransferModule\Console\Command\ImportSqlCommand;
use Visiosoft\TransferModule\Console\Command\TransferIdRsaCommand;
use Visiosoft\TransferModule\Transfer\Contract\TransferRepositoryInterface;
use Visiosoft\TransferModule\Transfer\TransferRepository;
use Anomaly\Streams\Platform\Model\Transfer\TransferTransfersEntryModel;
use Visiosoft\TransferModule\Transfer\TransferModel;

class TransferModuleServiceProvider extends AddonServiceProvider
{

    /**
     * The addon Artisan commands.
     *
     * @type array|null
     */
    protected $commands = [
        CheckIdRsaCommand::class,
        DirectoryTransferCommand::class,
        DumpSqlCommand::class,
        ImportSqlCommand::class,
        TransferIdRsaCommand::class,
    ];

    /**
     * The addon routes.
     *
     * @type array|null
     */
    protected $routes = [
        'admin/transfer' => 'Visiosoft\TransferModule\Http\Controller\Admin\TransfersController@index',
        'admin/transfer/create' => 'Visiosoft\TransferModule\Http\Controller\Admin\TransfersController@create',
        'admin/transfer/edit/{id}' => 'Visiosoft\TransferModule\Http\Controller\Admin\TransfersController@edit',
    ];

    /**
     * The addon class bindings.
     *
     * @type array|null
     */
    protected $bindings = [
        TransferTransfersEntryModel::class => TransferModel::class,
    ];

    /**
     * The addon singleton bindings.
     *
     * @type array|null
     */
    protected $singletons = [
        TransferRepositoryInterface::class => TransferRepository::class,
    ];
}
