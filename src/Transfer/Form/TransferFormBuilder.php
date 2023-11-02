<?php namespace Visiosoft\TransferModule\Transfer\Form;

use Anomaly\Streams\Platform\Ui\Form\FormBuilder;

class TransferFormBuilder extends FormBuilder
{

    /**
     * The form fields.
     *
     * @var array|string
     */
    protected $fields = [
        'name',
        'target',
        'source_ip',
        'source_port',
        'source_username',
        'source_password',
        'source_directory_path',
        'transfer_database',
        'source_database',
        'source_database_user',
        'source_database_password'
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
    protected $options = [];

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
