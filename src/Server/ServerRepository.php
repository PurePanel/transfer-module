<?php namespace Visiosoft\TransferModule\Server;

use Visiosoft\TransferModule\Server\Contract\ServerRepositoryInterface;
use Anomaly\Streams\Platform\Entry\EntryRepository;

class ServerRepository extends EntryRepository implements ServerRepositoryInterface
{

    /**
     * The entry model.
     *
     * @var ServerModel
     */
    protected $model;

    /**
     * Create a new ServerRepository instance.
     *
     * @param ServerModel $model
     */
    public function __construct(ServerModel $model)
    {
        $this->model = $model;
    }
}
