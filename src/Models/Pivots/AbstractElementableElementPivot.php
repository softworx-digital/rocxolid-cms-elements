<?php

namespace Softworx\RocXolid\CMS\Elements\Models\Pivots;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\MorphPivot;
// rocXolid cms elements model contracts
use Softworx\RocXolid\CMS\Elements\Models\Contracts\Elementable;
use Softworx\RocXolid\CMS\Elements\Models\Contracts\Element;

/**
 * Cross model abstraction to connect elementable with morphed elements.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\CMS\Elements
 * @version 1.0.0
 * @todo this is actually not a MorphPivot, since the MorphManyThrough is not supported
 */
abstract class AbstractElementableElementPivot extends MorphPivot
{
    /**
     * {@inheritDoc}
     */
    protected $fillable = [
        'position',
        'is_enabled',
        'template',
    ];

    /**
     * Parent elementable connection.
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    abstract public function parent();

    /**
     * Obtain query conditions to substitute the parent key condition.
     *
     * @param \Softworx\RocXolid\CMS\Elements\Models\Contracts\Elementable $parent
     * @param \Softworx\RocXolid\CMS\Elements\Models\Contracts\Element $element
     * @return array
     */
    abstract public function getPrimaryKeyWhereCondition(?Elementable $parent = null, ?Element $element = null): array;

    /**
     * Element connection.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function element(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Create associations to parent and element.
     *
     * @param \Softworx\RocXolid\CMS\Elements\Models\Contracts\Elementable $parent
     * @param \Softworx\RocXolid\CMS\Elements\Models\Contracts\Element $element
     * @return \Softworx\RocXolid\CMS\Elements\Models\Pivots\AbstractElementableElementPivot
     */
    public function setElement(Elementable $parent, Element $element): AbstractElementableElementPivot
    {
        $this->parent()->associate($parent);
        $this->element()->associate($element);

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getTable()
    {
        return sprintf('cms_%s_has_elements', Str::snake((new \ReflectionClass($this->parent()->getRelated()))->getShortName()));
    }

    /**
     * {@inheritDoc}
     *
     * This is overriden because of morphType = morphClass condition
     * which is not applicable, since this is not a true pivot (yet).
     */
    public function delete()
    {
        if ($this->fireModelEvent('deleting') === false) {
            return 0;
        }

        $query = $this->getDeleteQuery();

        return tap($query->delete(), function () {
            $this->fireModelEvent('deleted', false);
        });
    }

    /**
     * {@inheritDoc}
     */
    protected function setKeysForSaveQuery($query)
    {
        $query->where($this->getPrimaryKeyWhereCondition());

        return $query;
    }

    /**
     * {@inheritDoc}
     */
    protected function getDeleteQuery()
    {
        return $this->newQueryWithoutRelationships()->where($this->getPrimaryKeyWhereCondition());
    }
}
