<?php

namespace Softworx\RocXolid\CMS\Elements\Http\Controllers;

// rocXolid utils
use Softworx\RocXolid\Http\Requests\FormRequest;
// rocXolid form field contracts
use Softworx\RocXolid\Forms\Contracts\FormField;
// rocXolid cms model contracts
use Softworx\RocXolid\CMS\Models\Contracts\Elementable;
// rocXolid cms models
use Softworx\RocXolid\CMS\Models\PageProxy;
// rocXolid cms elements controllers
use Softworx\RocXolid\CMS\Elements\Http\Controllers\AbstractElementController;

// @todo - cele refactornut - vzhladom na pagelementable a pageelementy, ktore mozu mat v sebe elementy (containery)
abstract class AbstractElementProxyController extends AbstractElementController
{
    // @todo - zrejme posielat aj classu + test na interface po find instancie a neifovat to - skarede
    public function getPageElementable(FormRequest $request): Elementable
    {
        if (!$request->has(FormField::SINGLE_DATA_PARAM)) {
            throw new \InvalidArgumentException(sprintf('Undefined [%s] param in request', FormField::SINGLE_DATA_PARAM));
        }

        $data = collect($request->get(FormField::SINGLE_DATA_PARAM));

        if ($data->has('_page_proxy_id')) {
            $page_elementable = PageProxy::findOrFail($data->get('_page_proxy_id'));
        }

        if (!isset($page_elementable)) {
            throw new \InvalidArgumentException(sprintf('Undefined _page_proxy_id'));
        }

        return $page_elementable;
    }
}
