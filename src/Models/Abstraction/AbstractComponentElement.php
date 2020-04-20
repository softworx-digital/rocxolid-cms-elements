<?php

namespace Softworx\RocXolid\CMS\Elements\Models\Abstraction;

// rocXolid cms elements models
use Softworx\RocXolid\CMS\Elements\Models\Abstraction\AbstractElement;

/**
 * Abstraction for component element models.
 * Components cannot have any containees.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\CMS\Elements
 * @version 1.0.0
 */
abstract class AbstractComponentElement extends AbstractElement
{
    /**
     * {@inheritDoc}
     */
    public function getDocumentEditorComponentType(): string
    {
        return sprintf('component-%s', $this->getElementTypeParam());
    }

    /**
     * {@inheritDoc}
     */
    public function getTable()
    {
        return sprintf('cms_component_%s', $this->getTableBaseName());
    }
}
