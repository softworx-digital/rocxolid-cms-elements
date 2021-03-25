<?php

namespace Softworx\RocXolid\CMS\Elements\Http\Controllers;

// rocXolid utils
use Softworx\RocXolid\Http\Requests\CrudRequest;
// rocXolid model contracts
use Softworx\RocXolid\Models\Contracts\Crudable as CrudableModel;
// rocXolid cms components
use Softworx\RocXolid\CMS\Components\ModelViewers\ContainerViewer;
// rocXolid cms elements controllers
use Softworx\RocXolid\CMS\Elements\Http\Controllers\AbstractElementController;

/**
 * CMS Elements controller for elements serving as lists.
 * Provides features to setup list elements and their containees.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\CMS\Elements
 * @version 1.0.0
 */
abstract class AbstractListElementController extends AbstractElementController
{
    protected static $model_viewer_type = ContainerViewer::class;

    protected $form_mapping = [
        'create' => 'create',
        'store' => 'create',
        'edit' => 'update',
        'update' => 'update',
        //
        'create.page-elements' => 'create-in-page-elementable',
        'store.page-elements' => 'create-in-page-elementable',
        'edit.page-elements' => 'update-in-page-elementable',
        'update.page-elements' => 'update-in-page-elementable',
        //
        'listContainee' => 'list-containee',
        'selectContainee' => 'list-containee',
        'listContaineeReplace' => 'list-containee-replace',
        'listContaineeReplaceSubmit' => 'list-containee-replace',
    ];

    public function getContaineeClass()
    {
        return static::$containee_class;
    }

    public function reorder(CrudRequest $request, CrudableModel $model, string $relation)//: View
    {
        if (($order = $request->input('_data', false)) && is_array($order)) {
            foreach ($order as $containee_order_data) {
                $model->reorderContainees('items', $containee_order_data);
            }
        }

        $model_viewer_component = $this->getModelViewerComponent($model);

        return $this->response
            ->notifySuccess($model_viewer_component->translate('text.updated'))
            ->get();
    }

    public function listContainee(CrudRequest $request, CrudableModel $model)
    {
        $form = $this
            ->getForm($request, $model)
            ->setContaineeClass(static::$containee_class);

        $model_viewer_component = $this->getModelViewerComponent(
            $model,
            $this->getFormComponent($form)
        );

        return $this->response
            ->modal($model_viewer_component->fetch('modal.select-containee', [
                //'page_element_short_class' => $page_element_short_class,
            ]))
            ->get();
    }

    public function selectContainee(CrudRequest $request, CrudableModel $model)
    {
        $form = $this
            ->getForm($request, $model)
            ->setContaineeClass(static::$containee_class)
            ->submit();

        $model_viewer_component = $this->getModelViewerComponent(
            $model,
            $this->getFormComponent($form)
        );

        if ($form->isValid()) {
            // @todo quick hack na handlovanie radio + checkbox
            $values = $form->getFormField('containee_id')->getValue();

            if (!is_array($values)) {
                $values = [ $values ];
            }

            foreach ($values as $id) {
                $containee = $form->getContaineeModel()->find($id);

                if ($model->hasContainee('items', $containee)) {
                    return $this->response
                        ->notifyError($model_viewer_component->translate('text.element-already-set'))
                        ->get();
                }
            }

            foreach ($values as $id) {
                $containee = $form->getContaineeModel()->find($id);

                $model->attachContainee('items', $containee);
            }

            return $this->response->redirect($model->getControllerRoute('show'))->get();
        /*
        return $this->response
            ->replace($model_viewer_component->getDomId('list-containee', $model->getKey()), $model_viewer_component->fetch('include.list-containee'))
            ->modalClose($model_viewer_component->getDomId('modal-select-list-containee'))
            ->get();
        */
        } else {
            return $this->errorResponse($request, $model, $form, 'update');
        }
    }

    public function listContaineeReplace(CrudRequest $request, CrudableModel $model)
    {
        $form = $this
            ->getForm($request, $model)
            ->setContaineeClass(static::$containee_class);

        $model_viewer_component = $this->getModelViewerComponent(
            $model,
            $this->getFormComponent($form)
        );

        return $this->response
            ->modal($model_viewer_component->fetch('modal.replace-list', []))
            ->get();
    }

    public function listContaineeReplaceSubmit(CrudRequest $request, CrudableModel $model)
    {
        $form = $this
            ->getForm($request, $model)
            ->setContaineeClass(static::$containee_class)
            ->submit();

        if ($form->isValid()) {
            $this->reattachContainees($model, $form->getFormField('order_by_attribute')->getValue());

            return $this->response->redirect($model->getControllerRoute('show'))->get();
        } else {
            return $this->errorResponse($request, $model, $form, 'update');
        }
    }

    protected function reattachContainees(CrudableModel $model, string $order_by)
    {
        $model->detachContainee('items');

        $items_class = static::$containee_class;

        $items_class::orderBy($order_by)->get()->each(function ($containee, $key) use ($model) {
            $model->attachContainee('items', $containee);
        });

        return $this;
    }
}
