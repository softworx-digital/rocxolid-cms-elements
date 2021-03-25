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
// rocXolid cms elements model traits
use Softworx\RocXolid\CMS\Elements\Models\Traits as Traits;

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
    use Traits\HasElements;

    /**
     * {@inheritDoc}
     */
    public function getDocumentEditorElementType(): string
    {
        return 'container';
    }

    /**
     * {@inheritDoc}
     */
    public function getDocumentEditorElementSnippetPreview(): string
    {
        return $this->getDocumentEditorElementSnippetPreviewAssetPath('container');
    }

    /**
     * {@inheritDoc}
     */
    public function getDocumentEditorElementSnippetTitle(): string
    {
        return $this->getModelViewerComponent()->translate(sprintf('model.title.%s', $this->getTemplate()));
    }

    /**
     * {@inheritDoc}
     */
    public function getDocumentEditorElementSnippetCategories(): Collection
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

    /**
     * {@inheritDoc}
     */
    protected static function getConfigFilePathKey(): string
    {
        return 'rocXolid.cms-elements.container';
    }
}
