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
abstract class AbstractElementComponent extends AbstractElement
{
    public function getDocumentEditorComponentType()
    {
        return sprintf('component-%s', $this->getElementTypeParam());
    }
}
