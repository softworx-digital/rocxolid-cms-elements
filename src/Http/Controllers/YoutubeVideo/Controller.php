<?php

namespace Softworx\RocXolid\CMS\Elements\Http\Controllers\YoutubeVideo;

// rocXolid utils
use Softworx\RocXolid\Http\Requests\CrudRequest;
// rocXolid forms
use Softworx\RocXolid\Forms\AbstractCrudForm;
// rocXolid model contracts
use Softworx\RocXolid\Models\Contracts\Crudable;
// rocXolid cms elements controllers
use Softworx\RocXolid\CMS\Elements\Http\Controllers\AbstractCrudController;
// rocXolid cms elements components
use Softworx\RocXolid\CMS\Elements\Components\ModelViewers\Element as ElementModelViewer;

/**
 * YoutubeVideo element model controller.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\CMS\Elements
 * @version 1.0.0
 */
class Controller extends AbstractCrudController
{
    /**
     * {@inheritDoc}
     */
    protected static $model_viewer_type = ElementModelViewer::class;

    /**
     * @inheritDoc
     */
    protected function successAjaxUpdateResponse(CrudRequest $request, Crudable $model, AbstractCrudForm $form)
    {
        $model_viewer_component = $this->getModelViewerComponent($model);

        return $this->response
            ->notifySuccess($model_viewer_component->translate('text.updated'))
            ->modalClose($model_viewer_component->getDomId(sprintf('modal-%s', $form->getParam())))
            ->redirect('')
            ->get();
    }
}
