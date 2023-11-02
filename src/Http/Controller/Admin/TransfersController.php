<?php namespace Visiosoft\TransferModule\Http\Controller\Admin;

use Visiosoft\TransferModule\Transfer\Form\TransferFormBuilder;
use Visiosoft\TransferModule\Transfer\Table\TransferTableBuilder;
use Anomaly\Streams\Platform\Http\Controller\AdminController;

class TransfersController extends AdminController
{

    /**
     * Display an index of existing entries.
     *
     * @param TransferTableBuilder $table
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(TransferTableBuilder $table)
    {
        return $table->render();
    }

    /**
     * Create a new entry.
     *
     * @param TransferFormBuilder $form
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function create(TransferFormBuilder $form)
    {
        return $form->render();
    }

    /**
     * Edit an existing entry.
     *
     * @param TransferFormBuilder $form
     * @param        $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function edit(TransferFormBuilder $form, $id)
    {
        return $form->render($id);
    }
}
