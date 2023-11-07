<?php namespace Visiosoft\TransferModule;

use Anomaly\Streams\Platform\Addon\Module\Module;

class TransferModule extends Module
{

    /**
     * The navigation display flag.
     *
     * @var bool
     */
    protected $navigation = true;

    /**
     * The addon icon.
     *
     * @var string
     */
    protected $icon = 'fa fa-puzzle-piece';

    /**
     * The module sections.
     *
     * @var array
     */
    protected $sections = [
        'transfers' => [
            'buttons' => [
                'new_transfer',
                'new_server_transfer' => [
                    'href' => '/admin/transfer/server/transfer',
                    'icon' => 'plus'
                ],
            ],
        ],
        'server' => [
            'buttons' => [
                'new_server',
            ],
        ],
    ];

}
