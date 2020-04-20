<?php

namespace Softworx\RocXolid\CMS\Elements\Models\Abstraction;

// rocXolid cms elements model contracts
use Softworx\RocXolid\CMS\Elements\Models\Contracts\ListElement;
// rocXolid cms elements models
use Softworx\RocXolid\CMS\Elements\Models\Abstraction\AbstractComponentElement;

/**
 * Abstraction for list element models.
 * Lists can have other models assigned.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\CMS\Elements
 * @version 1.0.0
 */
abstract class AbstractListComponentElement extends AbstractComponentElement implements ListElement
{
    /**
     * {@inheritDoc}
     */
    public function getTable()
    {
        return sprintf('cms_list_%s', parent::getTable());
    }
}
