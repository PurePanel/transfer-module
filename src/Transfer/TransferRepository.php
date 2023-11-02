<?php namespace Visiosoft\TransferModule\Transfer;

use Visiosoft\TransferModule\Transfer\Contract\TransferRepositoryInterface;
use Anomaly\Streams\Platform\Entry\EntryRepository;

class TransferRepository extends EntryRepository implements TransferRepositoryInterface
{

    /**
     * The entry model.
     *
     * @var TransferModel
     */
    protected $model;

    /**
     * Create a new TransferRepository instance.
     *
     * @param TransferModel $model
     */
    public function __construct(TransferModel $model)
    {
        $this->model = $model;
    }
}
