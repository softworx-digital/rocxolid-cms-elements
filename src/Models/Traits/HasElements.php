<?php

namespace Softworx\RocXolid\CMS\Elements\Models\Traits;

use Illuminate\Support\Str;
use Illuminate\Support\Collection;
// rocXolid cms model contracts
use Softworx\RocXolid\CMS\Elements\Models\Contracts\Elementable;
// // rocXolid cms model pivot
use Softworx\RocXolid\CMS\Models\Pivots\ElementableElement;
// rocXolid cms elements model contracts
use Softworx\RocXolid\CMS\Elements\Models\Contracts\Element;

/**
 * Enables models to have elements assigned.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\CMS
 * @version 1.0.0
 */
trait HasElements
{
    /**
     * Temporary element container used for building and persisting element structure.
     *
     * @var \Illuminate\Support\Collection
     */
    private $elements_bag;

    /**
     * {@inheritDoc}
     */
    public function addElement(Element $element): Elementable
    {
        $this->elementsBag()->push($element);

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function elementsBag(): Collection
    {
        $this->elements_bag = $this->elements_bag ?? collect();

        return $this->elements_bag;
    }

    /**
     * {@inheritDoc}
     */
    public function saveElement(Element $element): Elementable
    {
        $element->save();

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function savePivot(Element $element): Elementable
    {
        $pivot = $this
            ->getPivot($element)
            ->setElement($this, $element)
            ->fill($element->getPivotData()->toArray());

        // $this->elementsPivots->add($pivot); // non-persistent
        $this->elementsPivots()->save($pivot);

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function elements(): Collection
    {
        // $this->elementsPivots()->with('element')
        return $this
            ->elementsPivots()
            ->with('element')
            ->orderBy('position')
            ->get()
            ->map(function ($pivot) {
                return $pivot->element->setPivotData(collect($pivot->attributesToArray()));
            });
    }

    /**
     * Make pivot model type for elementsPivots relationship based on elementable namespace and type.
     *
     * @return string
     */
    protected function getElementsPivotType(): string
    {
        $reflection = new \ReflectionClass($this);

        return sprintf('%s\Pivots\%sElement', $reflection->getNamespaceName(), $reflection->getShortName());
    }
}
