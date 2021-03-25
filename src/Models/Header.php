<?php

namespace Softworx\RocXolid\CMS\Elements\Models;

// rocXolid cms elements model contracts
use Softworx\RocXolid\CMS\Elements\Models\Contracts\Element;
// rocXolid cms elements models
use Softworx\RocXolid\CMS\Elements\Models\Abstraction\AbstractContainerElement;

/**
 * Header container component.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\CMS\Elements
 * @version 1.0.0
 */
class Header extends AbstractContainerElement
{
    /**
     * {@inheritDoc}
     */
    public function getDocumentEditorElementType(): string
    {
        return 'container-content';
    }

    /**
     * {@inheritDoc}
     */
    public function gridLayoutClass(): string
    {
        return 'header';
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
        return $this->getDocumentEditorElementSnippetPreviewAssetPath('header');
    }

    /**
     * {@inheritDoc}
     */
    public function getDocumentEditorElementSnippetTitle(): string
    {
        return $this->getModelViewerComponent()->translate('model.title.singular');
    }
}
