<?php

namespace Softworx\RocXolid\CMS\Elements\Models;

// rocXolid cms models
use Softworx\RocXolid\CMS\Elements\Models\Abstraction\AbstractContainerElement;

/**
 * Grid row container component.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\CMS\Elements
 * @version 1.0.0
 */
class GridRow extends AbstractContainerElement
{
    /**
     * {@inheritDoc}
     */
    public function gridLayoutClass(): string
    {
        return 'row';
    }

    public function addFakeColumns(int $count)
    {
        $this->forgetElements();

        for ($i = 0; $i < $count; $i++) {
            $column = app(GridColumn::class)->fill([
                'grid_layout' => json_encode([
                    'sm' => (int)(12 / $count)
                ])
            ]);

            $this->elements()->push($column);
        }

        return $this;
    }
}
