<?php namespace Visiosoft\TransferModule\Server\ServerTransferForm;

use Anomaly\Streams\Platform\Ui\Form\FormBuilder;
use Visiosoft\TransferModule\Server\ServerModel;

class ServerTransferFormBuilder extends FormBuilder
{

    /**
     * The form fields.
     *
     * @var array|string
     */
    protected $fields = [
        'server' => [
            'label' => 'visiosoft.module.transfer::field.server.name',
            'type' => 'anomaly.field_type.relationship',
            'required' => true,
            'config' => [
                'related' => ServerModel::class,
                'mode' => 'lookup'
            ],
        ],
        'username' => [
            'label' => 'visiosoft.module.transfer::field.username.name',
            'instructions' => 'visiosoft.module.transfer::field.username.instructions',
            'type' => 'anomaly.field_type.text',
            'required' => true,
        ],
        'database_name' => [
            'label' => 'visiosoft.module.transfer::field.database_name.name',
            'type' => 'anomaly.field_type.text',
            'required' => true,
        ],
        'target_site' => [
            'label' => 'visiosoft.module.transfer::field.target_site.name',
            'instructions' => 'visiosoft.module.transfer::field.target_site.instructions',
            'type' => 'anomaly.field_type.relationship',
            'required' => true,
            'config' => [
                'related' => \Visiosoft\SiteModule\Site\SiteModel::class,
                'mode' => 'lookup'
            ]
        ],
    ];

    /**
     * Additional validation rules.
     *
     * @var array|string
     */
    protected $rules = [];

    /**
     * Fields to skip.
     *
     * @var array|string
     */
    protected $skips = [];

    /**
     * The form actions.
     *
     * @var array|string
     */
    protected $actions = [];

    /**
     * The form buttons.
     *
     * @var array|string
     */
    protected $buttons = [
        'cancel',
    ];

    /**
     * The form options.
     *
     * @var array
     */
    protected $options = [
        'redirect' => '/admin/transfer'
    ];

    /**
     * The form sections.
     *
     * @var array
     */
    protected $sections = [];

    /**
     * The form assets.
     *
     * @var array
     */
    protected $assets = [];

}
