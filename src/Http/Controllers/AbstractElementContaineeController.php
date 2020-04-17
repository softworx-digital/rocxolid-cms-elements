<?php

namespace Softworx\RocXolid\CMS\Elements\Http\Controllers;

// @todo: cleanup
use Illuminate\Support\Str;
// rocXolid fundamentals
use Softworx\RocXolid\Http\Requests\CrudRequest;
use Softworx\RocXolid\Http\Controllers\Contracts\Crudable as CrudableController;
use Softworx\RocXolid\Forms\AbstractCrudForm;
use Softworx\RocXolid\Forms\Contracts\FormField;
use Softworx\RocXolid\Models\Contracts\Crudable as CrudableModel;
use Softworx\RocXolid\Models\Contracts\Container;
// rocXolid cms elements controllers
use Softworx\RocXolid\CMS\Elements\Http\Controllers\AbstractElementController;

/**
 * CMS Elements controller for elements serving as containees - those contained by container elements.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\CMS\Elements
 * @version 1.0.0
 */
abstract class AbstractElementContaineeController extends AbstractElementController
{
    public function getContainer(CrudRequest $request)
    {
        if (!$request->has(FormField::SINGLE_DATA_PARAM)) {
            throw new \InvalidArgumentException(sprintf('Undefined [%s] param in request', FormField::SINGLE_DATA_PARAM));
        }

        $data = collect($request->get(FormField::SINGLE_DATA_PARAM));

        if (!$data->has('container_id')
         || !$data->has('container_type')
         || !$data->has('container_relation')) {
            throw new \InvalidArgumentException(sprintf(
                'Invalid container data [%s] [%s] [%s]',
                $data->get('container_id', 'undefined'),
                $data->get('container_type', 'undefined'),
                $data->get('container_relation', 'undefined')
            ));
        }

        $container_class = $data->get('container_type');
        $container = $container_class::findOrFail($data->get('container_id'));

        return $container;
    }

    // @todo: docblock & cleanup
    public function detach(CrudRequest $request, CrudableModel $model)
    {
        if (!$request->has('_section'))
        {
            throw new \InvalidArgumentException('Missing [_section] param in request');
        }

        $container = $this->getContainer($request);

        $data = collect($request->get(FormField::SINGLE_DATA_PARAM));

        $container->detachContainee($data->get('container_relation'), $model);

        $container_controller = $container->getCrudController();
        $container_model_viewer_component = $container_controller->getModelViewerComponent($container);
        $template_name = sprintf('include.%s', $request->_section);

        return $this->response
            ->destroy($model->getModelViewerComponent()->getDomId($request->_section, md5(get_class($model)), $model->getKey()))
            ->get();
    }

    /**
     * {@inheritDoc}
     */
    protected function onModelUpdated(CrudRequest $request, CrudableModel $containee, AbstractCrudForm $form): CrudableController
    {
        if (!$request->has('_section'))
        {
            throw new \InvalidArgumentException('Missing [_section] param in request');
        }

        $section_action_method = sprintf('handle%s%s', Str::studly($request->get('_section')), Str::studly($form->getParam()));

        if (!method_exists($this, $section_action_method))
        {
            throw new \RuntimeException(sprintf('Invalid method call [%s] in [%s]', $section_action_method, get_class($this)));
        }

        return $this->$section_action_method($request, $repository, $form, $containee, $containee->getContainerElement($request));
    }

    /**
     * @todo: docblock
     *
     * @param \Softworx\RocXolid\Http\Requests\CrudRequest $request
     * @param \Softworx\RocXolid\Forms\AbstractCrudForm $form
     * @param \Softworx\RocXolid\Models\Contracts\Container $container
     * @return AbstractPageElementContaineeController
     */
    protected function updateContaineeResponse(CrudRequest $request, AbstractCrudForm $form, Container $container): AbstractPageElementContaineeController
    {
        $model_viewer_component = $this->getModelViewerComponent();

        $template_name = sprintf('include.%s', $request->input('_section'));

        $this->response
            ->replace(
                $model_viewer_component->getDomId(
                    $request->get('_section'),
                    md5(get_class($form->getModel())),
                    $form->getModel()->getKey()
                ),
                $model_viewer_component->fetch($template_name, [
                    'container' => $container,
                ])
            );

        return $this;
    }
}
