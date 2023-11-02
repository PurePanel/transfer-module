<?php namespace Visiosoft\TransferModule\Transfer\Table;

use Anomaly\Streams\Platform\Entry\Contract\EntryInterface;

class TransferTableColumns
{
    public function handle(TransferTableBuilder $builder)
    {

        $columns = [
            'created_at' => [
                'wrapper' => '<strong>{value.datetime}</strong><br><small>{value.timeago}</small>',
                'value' => [
                    'datetime' => 'entry.created_at_datetime',
                    'timeago' => 'entry.created_at.diffForHumans()',
                ],
            ],
            'name',
            'target' => [
                'wrapper' => '{value.name}',
                'value' => [
                    'name' => function (EntryInterface $entry) {
                        return $entry->getTarget()->getUsername();
                    }
                ]
            ],
            'source_ip',
            'source_directory_path',
            'updated_at' => [
                'wrapper' => '<strong>{value.datetime}</strong><br><small>{value.timeago}</small>',
                'value' => [
                    'datetime' => 'entry.updated_at_datetime',
                    'timeago' => 'entry.updated_at.diffForHumans()',
                ],
            ],
            'status' => [
                'wrapper' => '{value.name}',
                'value' => [
                    'name' => function (EntryInterface $entry) {
                        return trans('visiosoft.module.transfer::message.' . $entry->getStatus());
                    }
                ]
            ],
        ];

        $builder->setColumns($columns);
    }

}