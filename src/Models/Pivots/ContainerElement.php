<?php

namespace Softworx\RocXolid\CMS\Elements\Models\Pivots;

// rocXolid cms elements model pivots
use Softworx\RocXolid\CMS\Elements\Models\Pivots\AbstractElementableElementPivot;
// rocXolid cms elements model contracts
use Softworx\RocXolid\CMS\Elements\Models\Contracts\Elementable;
use Softworx\RocXolid\CMS\Elements\Models\Contracts\Element;

/**
 * Cross model abstraction to connect element container with morphed elements.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\CMS\Elements
 * @version 1.0.0
 */
class ContainerElement extends AbstractElementableElementPivot
{
    /**
     * {@inheritDoc}
     */
    public function parent()
    {
        return $this->morphTo('container');
    }

    /**
     * {@inheritDoc}
     */
    public function getTable()
    {
        return 'cms_container_has_elements';
    }

    /**
     * {@inheritDoc}
     */
    public function getPrimaryKeyWhereCondition(?Elementable $parent = null, ?Element $element = null): array
    {
        $parent = $parent ?? $this->parent ?? $this->parent()->getRelated();
        $element = $element ?? $this->element ??$this->element()->getRelated();

        return [
            $this->parent()->getMorphType() => get_class($parent),
            $this->parent()->getForeignKeyName() => $parent->getKey(),
            $this->element()->getMorphType() => get_class($element),
            $this->element()->getForeignKeyName() => $element->getKey(),
        ];
    }
}