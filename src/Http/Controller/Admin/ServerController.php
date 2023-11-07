<?php namespace Visiosoft\TransferModule\Http\Controller\Admin;

use Visiosoft\TransferModule\Server\Form\ServerFormBuilder;
use Visiosoft\TransferModule\Server\ServerTransferForm\ServerTransferFormBuilder;
use Visiosoft\TransferModule\Server\Table\ServerTableBuilder;
use Anomaly\Streams\Platform\Http\Controller\AdminController;

class ServerController extends AdminController
{

    /**
     * Display an index of existing entries.
     *
     * @param ServerTableBuilder $table
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(ServerTableBuilder $table)
    {
        return $table->render();
    }

    /**
     * Create a new entry.
     *
     * @param ServerFormBuilder $form
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function create(ServerFormBuilder $form)
    {
        return $form->render();
    }

    /**
     * Edit an existing entry.
     *
     * @param ServerFormBuilder $form
     * @param        $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function edit(ServerFormBuilder $form, $id)
    {
        return $form->render($id);
    }

    public function transfer(ServerTransferFormBuilder $builder)
    {
        return $builder->render();
    }
}
