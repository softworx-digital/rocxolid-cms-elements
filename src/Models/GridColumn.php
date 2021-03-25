<?php

namespace Softworx\RocXolid\CMS\Elements\Models;

use Illuminate\Support\Collection;
// rocXolid cms elements models
use Softworx\RocXolid\CMS\Elements\Models\Contracts\Element;
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
    use Traits\HasGridLayout;

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
    public function setElementData(Collection $data): Element
    {
        $this->fillGridLayout($data);

        return parent::setElementData($data);
    }

    /**
     * {@inheritDoc}
     */
    public function gridLayoutClass(): string
    {
        return $this->bootstrapBreakpoints();
    }

    /**
     * Make bootstrap column breakpoints.
     *
     * @return string
     */
    protected function bootstrapBreakpoints(): string
    {
        return collect(json_decode($this->grid_layout, true))->map(function ($size, $breakpoint) {
            return ($breakpoint === 'xs')
                ? sprintf('col-%s-%s col-%s', $breakpoint, $size, $size)
                : sprintf('col-%s-%s', $breakpoint, $size);
        })->join(' ');
    }
}
