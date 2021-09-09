<?php

namespace Softworx\RocXolid\CMS\Elements\Models;

// rocXolid cms elements model contracts
use Softworx\RocXolid\CMS\Elements\Models\Contracts\Element;
// rocXolid cms elements models
use Softworx\RocXolid\CMS\Elements\Models\Abstraction\AbstractContainerElement;

/**
 * Section container component.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\CMS\Elements
 * @version 1.0.0
 */
class Section extends AbstractContainerElement
{
    use Traits\HasContent;

    /**
     * {@inheritDoc}
     */
    public function gridLayoutClass(): string
    {
        return 'section';
    }

    /**
     * {@inheritDoc}
     */
    public function getContainer(): Element
    {
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getDocumentEditorElementSnippetPreview(): string
    {
        return $this->getDocumentEditorElementSnippetPreviewAssetPath('section');
    }
}
