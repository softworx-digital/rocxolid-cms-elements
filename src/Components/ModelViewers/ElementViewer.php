<?php

namespace Softworx\RocXolid\CMS\Elements\Components\ModelViewers;

use Softworx\RocXolid\CMS\Elements\Components\ModelViewers\CrudModelViewer;

class ElementViewer extends CrudModelViewer
{
    public function getElementDataAttributes(): string
    {
        return collect([
            'data-type' => $this->getModel()->getDocumentEditorComponentType(),
            'data-element-type' => $this->getModel()->getElementTypeParam(),
            'data-element-id' => $this->getModel()->getKey(),
        ])->filter()->map(function ($value, $attribute) {
            return sprintf('%s="%s"', $attribute, $value);
        })->join(' ');
    }
}
