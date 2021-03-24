<?php

namespace Softworx\RocXolid\CMS\Elements\Components\ModelViewers;

use Softworx\RocXolid\CMS\Elements\Components\ModelViewers\CrudModelViewer;
// rocXolid cms rendering contracts
use Softworx\RocXolid\CMS\Rendering\Contracts\Themeable;
// rocXolid cms rendering traits
use Softworx\RocXolid\CMS\Rendering\Traits\CanBeThemed;

/**
 * Model viewer for CMS elements.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\CMS\Elements
 * @version 1.0.0
 */
class ElementViewer extends CrudModelViewer implements Themeable
{
    use CanBeThemed;

    /**
     * Flag if the cache should be used when rendering this component.
     * Turning off caching because the view path is different from usual components.
     *
     * @var bool
     */
    protected $use_rendering_cache = false;

    /**
     * Provide HTML data attributes to be used in document editor templates for element identification.
     * This is called by standard model viewer for regular views rendering.
     *
     * @return string
     */
    public function getElementDataAttributes(): string
    {
        return collect([
            'data-type' => $this->getModel()->getDocumentEditorElementType(),
            'data-element-type' => $this->getModel()->getElementTypeParam(),
            'data-element-id' => $this->getModel()->getKey(),
            'data-element-template' => $this->getModel()->getTemplate(),
            'data-element-meta' => $this->getModel()->getMetaData(),
            'data-element-settings-url' => $this->getModel()->getSettingsUrl(),
        ])->filter()->map(function ($value, $attribute) {
            return sprintf('%s="%s"', $attribute, htmlspecialchars($value, ENT_QUOTES, 'UTF-8'));
        })->join(' ');
    }

    /**
     * Provide CSS class to the element.
     *
     * @return string
     */
    public function getElementCssClass(): string
    {
        return $this->getModel()->getElementTypeParam();
    }

    /**
     * Check if assigned model in presentation mode.
     *
     * @return bool
     */
    public function isPresenting(): bool
    {
        return $this->getModel()->isPresenting();
    }
}
