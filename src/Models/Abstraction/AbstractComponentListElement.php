<?php

namespace Softworx\RocXolid\CMS\Elements\Models\Abstraction;

use Illuminate\Support\Collection;
// rocXolid cms elements model contracts
use Softworx\RocXolid\CMS\Elements\Models\Contracts\ListElement;
// rocXolid cms elements models
use Softworx\RocXolid\CMS\Elements\Models\Abstraction\AbstractComponentElement;

/**
 * Abstraction for list element models.
 * List components serve as an item placeholder and are populated with real data when rendered.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\CMS\Elements
 * @version 1.0.0
 */
abstract class AbstractComponentListElement extends AbstractComponentElement implements ListElement
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
    public function getDocumentEditorComponentSnippetPreview(): string
    {
        return $this->getDocumentEditorComponentSnippetPreviewAssetPath('list');
    }

    /**
     * {@inheritDoc}
     */
    public function getDocumentEditorComponentSnippetTitle(): string
    {
        return $this->getModelViewerComponent()->translate(sprintf('model.title.%s', $this->getTemplate()));
    }

    /**
     * {@inheritDoc}
     */
    public function getDocumentEditorComponentSnippetCategories(): Collection
    {
        return collect($this->getModelViewerComponent()->translations('elementable.categories'));
    }

    /**
     * {@inheritDoc}
     */
    public function gridLayoutClass(): string
    {
        return 'list';
    }

    /**
     * {@inheritDoc}
     */
    public function getTable()
    {
        return sprintf('cms_component_list_%s', $this->getTableBaseName());
    }
}
