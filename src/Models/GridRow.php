<?php

namespace Softworx\RocXolid\CMS\Elements\Models;

use Illuminate\Support\Collection;
// rocXolid cms model contracts
use Softworx\RocXolid\CMS\Elements\Models\Contracts\Element;
// rocXolid cms models
use Softworx\RocXolid\CMS\Elements\Models\Abstraction\AbstractContainerElement;

/**
 * Grid row container component.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\CMS\Elements
 * @version 1.0.0
 */
class GridRow extends AbstractContainerElement
{
    /**
     * {@inheritDoc}
     */
    public function setDataOnCreate(Collection $data): Element
    {
        return $this;
    }
}
