<?php

namespace Softworx\RocXolid\CMS\Elements\Http\Controllers;

// rocXolid cms elements controllers
use Softworx\RocXolid\CMS\Elements\Http\Controllers\AbstractCrudController;
// rocXolid cms elements model viewers
use Softworx\RocXolid\CMS\Elements\Components\ModelViewers\ElementViewer;

// @todo - cele refactornut - vzhladom na pagelementable a pageelementy, ktore mozu mat v sebe elementy (containery)
abstract class AbstractElementController extends AbstractCrudController
{
    protected static $model_viewer_type = ElementViewer::class;






    /*
    protected $form_mapping = [
        'create' => 'create',
        'store' => 'create',
        'edit' => 'update',
        'update' => 'update',
        'create.page-elements' => 'create-in-page-elementable',
        'store.page-elements' => 'create-in-page-elementable',
        'edit.page-elements' => 'update-in-page-elementable',
        'update.page-elements' => 'update-in-page-elementable',
    ];

    // @todo: ugly
    public function getPageElementable(FormRequest $request): Elementable
    {
        if (!$request->has(FormField::SINGLE_DATA_PARAM)) {
            throw new \InvalidArgumentException(sprintf('Undefined [%s] param in request', FormField::SINGLE_DATA_PARAM));
        }

        $data = collect($request->get(FormField::SINGLE_DATA_PARAM));

        if ($data->has('_page_template_id')) {
            $page_elementable = PageTemplate::findOrFail($data->get('_page_template_id'));
        } elseif ($data->has('_page_proxy_id')) {
            $page_elementable = PageProxy::findOrFail($data->get('_page_proxy_id'));
        } elseif ($data->has('_page_id')) {
            $page_elementable = Page::findOrFail($data->get('_page_id'));
        } elseif ($data->has('_article_id')) {
            $page_elementable = Article::findOrFail($data->get('_article_id'));
        }

        if (!isset($page_elementable)) {
            throw new \InvalidArgumentException(sprintf('Undefined _page_template_id or _page_proxy_id or _page_id in request or _article_id'));
        }

        return $page_elementable;
    }

    public function detach(CrudRequest $request, CrudableModel $page_element)
    {
        if (!$request->has('_section'))
        {
            throw new \InvalidArgumentException('Missing [_section] param in request');
        }

        $page_elementable = $this->getPageElementable($request);
        $page_elementable->detachPageElement($page_element);

        $page_elementable_controller = $page_elementable->getCrudController();
        $page_elementable_model_viewer_component = $page_elementable_controller->getModelViewerComponent($page_elementable);
        $template_name = sprintf('include.%s', $request->_section);

        return $this->response
            ->replace($page_elementable_model_viewer_component->getDomId($request->_section, $page_elementable->getKey()), $page_elementable_model_viewer_component->fetch($template_name))
            ->get();
    }
    */

    /**
     * {@inheritDoc}
     *//*
    protected function onModelStored(CrudRequest $request, CrudableModel $page_element, AbstractCrudForm $form): CrudableController
    {
        $this->getPageElementable($request)->addPageElement($page_element);

        return parent::onModelStored($request, $page_element, $form);
    }*/

    /**
     * {@inheritDoc}
     *//*
    protected function successAjaxResponse(CrudRequest $request, CrudableModel $page_element, AbstractCrudForm $form)
    {
        $page_elementable = $this->getPageElementable($request);
        $page_elementable_controller = $page_elementable->getCrudController();
        $page_elementable_model_viewer_component = $page_elementable_controller->getModelViewerComponent($page_elementable);
        $template_name = sprintf('include.%s', $request->input('_section'));

        return $this->response->redirect($page_elementable->getControllerRoute('show'))->get();
        /*
        $this->response
            ->replace($page_elementable_model_viewer_component->getDomId($request->_section, $page_elementable->getKey()), $page_elementable_model_viewer_component->fetch($template_name));

        return $this;
        *//*
    }*/
}
