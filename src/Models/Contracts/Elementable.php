<?php

namespace Softworx\RocXolid\CMS\Elements\Models\Contracts;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Relations\MorphPivot;
use Illuminate\Database\Eloquent\Relations\HasOneOrMany;
// rocXolid model contracts
use Softworx\RocXolid\Models\Contracts\Crudable;
// rocXolid cms elements model contracts
use Softworx\RocXolid\CMS\Elements\Models\Contracts\Element;

/**
 * Enables models to have elements assigned.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\CMS\Elements
 * @version 1.0.0
 */
interface Elementable extends Crudable
{
    /**
     * Add element to the element's collection.
     *
     * @param \Softworx\RocXolid\CMS\Elements\Models\Contracts\Element $element
     * @return \Softworx\RocXolid\CMS\Elements\Models\Contracts\Elementable
     */
    public function addElement(Element $element): Elementable;

    /**
     * Persist the element in the structure.
     *
     * @param \Softworx\RocXolid\CMS\Elements\Models\Contracts\Element $element
     * @return \Softworx\RocXolid\CMS\Elements\Models\Contracts\Elementable
     */
    public function saveElement(Element $element): Elementable;

    /**
     * Persist the pivot - element connection in the structure.
     *
     * @param \Softworx\RocXolid\CMS\Elements\Models\Contracts\Element $element
     * @return \Softworx\RocXolid\CMS\Elements\Models\Contracts\Elementable
     */
    public function savePivot(Element $element): Elementable;

    /**
     * Intermediate relation to enable two-side polymorphism for elementables and elements.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOneOrMany
     */
    public function elementsPivots(): HasOneOrMany;

    /**
     * Retrieve pivot model for given element using tree search.
     *
     * @param \Softworx\RocXolid\CMS\Elements\Models\Contracts\Element $element
     * @return \Illuminate\Database\Eloquent\Relations\MorphPivot|null
     */
    public function findPivot(Element $element): ?MorphPivot;

    /**
     * Retrieve elements assigned to elementable.
     *
     * @return \Illuminate\Support\Collection
     */
    public function elements(): Collection;
}
