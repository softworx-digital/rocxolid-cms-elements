<?php

namespace Softworx\RocXolid\CMS\Elements\Http\Controllers;

// rocXolid utils
use Softworx\RocXolid\Http\Requests\CrudRequest;
// rocXolid forms
use Softworx\RocXolid\Forms\AbstractCrudForm;
// rocXolid model contracts
use Softworx\RocXolid\Models\Contracts\Crudable as CrudableModel;
// rocXolid components
use Softworx\RocXolid\Components\ModelViewers\CrudModelViewer as CrudModelViewerComponent;
// rocXolid cms elements controllers
use Softworx\RocXolid\CMS\Elements\Http\Controllers\AbstractCrudController;
// rocXolid cms elements components
use Softworx\RocXolid\CMS\Elements\Components\ModelViewers\Element as ElementModelViewer;

/**
 * General element model controller.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\CMS\Elements
 * @version 1.0.0
 */
abstract class AbstractElementController extends AbstractCrudController
{
    /**
     * {@inheritDoc}
     */
    protected static $model_viewer_type = ElementModelViewer::class;

    /**
     * {@inheritDoc}
     */
    /*
    protected function createAjax(CrudRequest $request, CrudModelViewerComponent $model_viewer_component)
    {
        return $this->response
            ->raw('form', $model_viewer_component->getFormComponent()->fetch('update'))
            ->get();
    }
    */

    /**
     * {@inheritDoc}
     */
    protected function editAjax(CrudRequest $request, CrudableModel $model, CrudModelViewerComponent $model_viewer_component)
    {
        return $this->response
            ->raw('form', $model_viewer_component->getFormComponent()->fetch('update'))
            ->get();
    }

    /**
     * {@inheritDoc}
     */
    protected function successAjaxResponse(CrudRequest $request, CrudableModel $model, AbstractCrudForm $form): array
    {
        $model_viewer_component = $this->getModelViewerComponent($model);

        return $this->response
            ->notifySuccess($model_viewer_component->translate('text.updated'))
            ->raw('meta_data', $model->getMetaData())
            ->get();
    }
}
