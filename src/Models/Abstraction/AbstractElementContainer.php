<?php

namespace Softworx\RocXolid\CMS\Elements\Models\Abstraction;

// rocXolid cms elements model contracts
use Softworx\RocXolid\CMS\Elements\Models\Contracts\ElementContainer;
// rocXolid cms elements models
use Softworx\RocXolid\CMS\Elements\Models\Abstraction\AbstractElement;

/**
 * Abstraction for container element models.
 * Containers can have other elements assigned.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\CMS\Elements
 * @version 1.0.0
 */
abstract class AbstractElementContainer extends AbstractElement implements ElementContainer
{
    public function getDocumentEditorComponentType()
    {
        return 'container';
    }
}
