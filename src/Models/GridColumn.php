<?php

namespace Softworx\RocXolid\CMS\Elements\Models;

// rocXolid cms models
use Softworx\RocXolid\CMS\Elements\Models\AbstractElementContainer;

/**
 * Grid column container component.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\CMS\Elements
 * @version 1.0.0
 */
class GridColumn extends AbstractElementContainer
{
    public function getDocumentEditorComponentType()
    {
        return 'container-content';
    }
}
