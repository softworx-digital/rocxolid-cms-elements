<?php

namespace Softworx\RocXolid\CMS\Elements\Models\Pivots;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\MorphPivot;
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
class ContainerElement extends MorphPivot
{
    protected $fillable = [
        'position',
        'is_enabled',
        'template',
    ];

    protected function setKeysForSaveQuery(Builder $query)
    {
        $query
            ->where([
                $this->container()->getMorphType() => get_class($this->container()->getRelated()),
                $this->container()->getForeignKeyName() =>$this->container()->getRelated()->getKey(),
                $this->element()->getMorphType() => get_class($this->element()->getRelated()),
                $this->element()->getForeignKeyName() => $this->element()->getRelated()->getKey(),
            ]);

        return $query;
    }

    public function setElement(Elementable $container, Element $element)
    {
        $this->container()->associate($container);
        $this->element()->associate($element);

        return $this;
    }

    public function container()
    {
        return $this->morphTo();
    }

    public function element()
    {
        return $this->morphTo();
    }

    public function getTable()
    {
        return 'cms_container_has_elements';
    }
}