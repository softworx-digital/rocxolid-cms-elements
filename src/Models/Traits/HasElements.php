<?php

namespace Softworx\RocXolid\CMS\Elements\Models\Traits;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Relations\MorphPivot;
// rocXolid cms model contracts
use Softworx\RocXolid\CMS\Elements\Models\Contracts\Elementable;
// rocXolid cms elements model contracts
use Softworx\RocXolid\CMS\Elements\Models\Contracts\Element;
// rocXolid cms elements builders
use Softworx\RocXolid\CMS\Elements\Builders\ElementBuilder;

/**
 * Enables models to have elements assigned.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\CMS\Elements
 * @version 1.0.0
 */
trait HasElements
{
    /**
     * In-memory element container used for building and persisting element structure.
     *
     * @var \Illuminate\Support\Collection
     */
    private $elements_bag;

    /**
     * {@inheritDoc}
     * @todo: make this somewhat seamless for in-memory (elementsBag) / persisted elements
     * @todo: optimize
     */
    public function elements(): Collection
    {
        $elements = $this
            ->elementsPivots()
            ->with('element')
            ->orderBy('position')
            ->get()
            ->map(function ($pivot) {
                return ElementBuilder::buildElement(
                    $pivot,
                    $this->getDependenciesProvider(),
                    $this->getMutatorsProvider(),
                    $this->getDependenciesDataProvider()
                );
            });

        return $elements->isNotEmpty() ? $elements : $this->elementsBag();
    }

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
    public function forgetElements(): Elementable
    {
        $this->elements_bag = collect();

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
            ->findOrNewPivot($element)
            ->setElement($this, $element)
            ->fill($element->getPivotData()->toArray());

        // $this->elementsPivots->add($pivot); // non-persistent
        $this->elementsPivots()->save($pivot);

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function findPivot(Element $element): ?MorphPivot
    {
        $type = $this->elementsPivots()->getRelated();

        return $type::where($type->getPrimaryKeyWhereCondition($this, $element))->firstOr(function() use ($element, $type) {
            $elementable = $this->elements()->filter(function($element) {
                return $element instanceof Elementable;
            });

            $pivot = $elementable->reduce(function ($carry, $child) use ($element, $type) {
                $pivot = $child->findPivot($element);

                if ($pivot && $carry) {
                    throw new \RuntimeException(sprintf(
                        'There are two pivots satisfying same condition [%s] pivot [%s], carry [%s]',
                        print_r($type->getPrimaryKeyWhereCondition($this, $element), true),
                        $pivot->toJson(),
                        $carry->toJson()
                    ));
                }

                return $pivot ?? $carry;
            });

            return $pivot;
        });
    }

    /**
     * Find direct pivot connecting model and element.
     *
     * @param \Softworx\RocXolid\CMS\Elements\Models\Contracts\Element $element
     * @return \Illuminate\Database\Eloquent\Relations\MorphPivot
     */
    protected function findOrNewPivot(Element $element): MorphPivot
    {
        $type = $this->elementsPivots()->getRelated();

        return $type::firstOrNew($type->getPrimaryKeyWhereCondition($this, $element));
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
