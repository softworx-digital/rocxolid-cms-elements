<?php

namespace Softworx\RocXolid\CMS\Elements\Models\Abstraction;

use Illuminate\Support\Collection;
// rocXolid traits
use Softworx\RocXolid\Traits\Modellable;
// rocXolid model contracts
use Softworx\RocXolid\Models\Contracts\Crudable;
// rocXolid cms elements model contracts
use Softworx\RocXolid\CMS\Elements\Models\Contracts\ProxyElement;
// rocXolid cms elements models
use Softworx\RocXolid\CMS\Elements\Models\Abstraction\AbstractComponentElement;
// use Softworx\RocXolid\CMS\Models\PageProxy;

/**
 * Abstraction for proxy element models.
 * Proxy elements are ment to be provided by a real model to handle its values.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\CMS\Elements
 * @version 1.0.0
 */
abstract class AbstractProxyComponentElement extends AbstractComponentElement implements ProxyElement
{
    use Modellable;

    /**
     * {@inheritDoc}
     */
    public function getTable()
    {
        return sprintf('cms_proxy_%s', parent::getTable());
    }

    /**
     * {@inheritDoc}
     */
    public function onCreateBeforeSave(Collection $data): Crudable
    {
dd('@todo', __METHOD__);
        if ($data->has('_page_proxy_id')) {
            $page_elementable = PageProxy::findOrFail($data->get('_page_proxy_id'));
        }

        if (!isset($page_elementable)) {
            throw new \InvalidArgumentException(sprintf('Undefined _page_template_id or _page_proxy_id or _page_id or _article_id'));
        }

        $this->web()->associate($page_elementable->web);

        return parent::onCreateBeforeSave($data);
    }
}
