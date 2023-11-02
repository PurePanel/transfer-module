<?php

use Anomaly\Streams\Platform\Database\Migration\Migration;

class VisiosoftModuleTransferCreateTransfersStream extends Migration
{

    /**
     * This migration creates the stream.
     * It should be deleted on rollback.
     *
     * @var bool
     */
    protected $delete = false;

    /**
     * The stream definition.
     *
     * @var array
     */
    protected $stream = [
        'slug' => 'transfers',
        'title_column' => 'name',
        'translatable' => false,
        'versionable' => false,
        'trashable' => true,
        'searchable' => false,
        'sortable' => false,
    ];

    /**
     * The addon fields.
     *
     * @var array
     */
    protected $fields = [
        'name' => 'anomaly.field_type.text',
        'target' => [
            'type' => 'anomaly.field_type.relationship',
            'config' => [
                'related' => \Visiosoft\SiteModule\Site\SiteModel::class,
                'mode' => 'lookup'
            ]
        ],
        'transfer_database' => [
            'type' => 'anomaly.field_type.boolean',
            'config' => [
                'default_value' => true
            ]
        ],
        'source_ip' => 'anomaly.field_type.text',
        'source_port' => 'anomaly.field_type.text',
        'source_username' => 'anomaly.field_type.text',
        'source_password' => 'anomaly.field_type.text',
        'source_database' => 'anomaly.field_type.text',
        'source_database_user' => 'anomaly.field_type.text',
        'source_database_password' => 'anomaly.field_type.text',
        'source_directory_path' => 'anomaly.field_type.text',
        'status' => "anomaly.field_type.integer"
    ];


    /**
     * The stream assignments.
     *
     * @var array
     */
    protected $assignments = [
        'name' => ['required' => true],
        'target' => ['required' => true],
        'source_ip' => ['required' => true],
        'source_port' => ['required' => true],
        'source_username' => ['required' => true],
        'source_password' => ['required' => true],
        'source_directory_path' => ['required' => true],
        'transfer_database',
        'source_database' => ['required' => true],
        'source_database_user' => ['required' => true],
        'source_database_password',
        'status'
    ];

}
