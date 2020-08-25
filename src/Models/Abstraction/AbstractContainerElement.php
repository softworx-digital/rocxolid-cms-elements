<?php

namespace Softworx\RocXolid\CMS\Elements\Models\Abstraction;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Relations\HasOneOrMany;
// rocXolid cms elements model pivots
use Softworx\RocXolid\CMS\Elements\Models\Pivots\ContainerElement as ContainerElementPivot;
// rocXolid cms elements model contracts
use Softworx\RocXolid\CMS\Elements\Models\Contracts\Element;
use Softworx\RocXolid\CMS\Elements\Models\Contracts\ContainerElement;
// rocXolid cms elements models
use Softworx\RocXolid\CMS\Elements\Models\Abstraction\AbstractElement;
// rocXolid cms elements model trraits
use Softworx\RocXolid\CMS\Elements\Models\Traits\HasElements;

/**
 * Abstraction for container element models.
 * Containers can have other elements assigned.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\CMS\Elements
 * @version 1.0.0
 */
abstract class AbstractContainerElement extends AbstractElement implements ContainerElement
{
    use HasElements;

    /**
     * {@inheritDoc}
     */
    public function getDocumentEditorComponentType(): string
    {
        return 'container';
    }

    /**
     * {@inheritDoc}
     */
    public function getDocumentEditorComponentSnippetPreview(): string
    {
        return $this->getDocumentEditorComponentSnippetPreviewAssetPath('container');
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
    public function getTable()
    {
        return sprintf('cms_container_%s', $this->getTableBaseName());
    }

    /**
     * {@inheritDoc}
     */
    public function elementsPivots(): HasOneOrMany
    {
        return $this->morphMany(ContainerElementPivot::class, 'container');
    }

    /**
     * {@inheritDoc}
     */
    public function nonEmptyElements(): Collection
    {
        return $this->elements()->filter(function (Element $element) {
            return !$element->isEmptyContent();
        });
    }
}
