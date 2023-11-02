<?php namespace Visiosoft\TransferModule\Transfer\Form;


use Visiosoft\TransferModule\Console\Command\StartTransfer;
use Visiosoft\TransferModule\Job\CheckLoginWithRsaJob;
use Visiosoft\TransferModule\Transfer\Helpers\TransferStatuses;

class TransferFormHandler
{
    public function handle(TransferFormBuilder $builder)
    {
        if (!$builder->canSave()) {
            return;
        }

        $builder->saveForm();
        $entry = $builder->getFormEntry();

        if ($builder->getForm()->getMode() == "create") {
            $entry->setStatus(TransferStatuses::TRANSFER_STARTING());
            CheckLoginWithRsaJob::dispatch($entry);
        }
    }
}
