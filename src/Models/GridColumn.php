<?php

namespace Softworx\RocXolid\CMS\Elements\Models;

// rocXolid cms models
use Softworx\RocXolid\CMS\Elements\Models\Abstraction\AbstractContainerElement;

/**
 * Grid column container component.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\CMS\Elements
 * @version 1.0.0
 */
class GridColumn extends AbstractContainerElement
{
    public function getDocumentEditorComponentType(): string
    {
        return 'container-content';
    }

    public function gridLayout()
    {
        return 'col-sm-6';
    }
}
