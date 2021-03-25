<?php

namespace Softworx\RocXolid\CMS\Elements\Models\Abstraction;

use Illuminate\Support\Collection;
// rocXolid cms elements model contracts
use Softworx\RocXolid\CMS\Elements\Models\Contracts\Element;
use Softworx\RocXolid\CMS\Elements\Models\Contracts\ComponentElement;
// rocXolid cms elements models
use Softworx\RocXolid\CMS\Elements\Models\Abstraction\AbstractElement;
// rocXolid cms elements model traits
use Softworx\RocXolid\CMS\Elements\Models\Traits as Traits;

/**
 * Abstraction for component element models.
 * Components cannot have any containees and do have a content.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\CMS\Elements
 * @version 1.0.0
 */
abstract class AbstractComponentElement extends AbstractElement implements ComponentElement
{
    use Traits\HasContent;

    /**
     * {@inheritDoc}
     */
    public function getDocumentEditorElementType(): string
    {
        return sprintf('component-%s', $this->getElementTypeParam());
    }

    /**
     * {@inheritDoc}
     */
    public function setElementData(Collection $data): Element
    {
        $this->fillContent($data);

        return parent::setElementData($data);
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
    public function gridLayoutClass(): string
    {
        return 'element';
    }

    /**
     * {@inheritDoc}
     */
    public function getTable()
    {
        return sprintf('cms_component_%s', $this->getTableBaseName());
    }

    /**
     * {@inheritDoc}
     */
    protected static function getConfigFilePathKey(): string
    {
        return 'rocXolid.cms-elements.component';
    }
}
