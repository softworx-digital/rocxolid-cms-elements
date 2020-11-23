<?php

namespace Softworx\RocXolid\CMS\Elements\Builders;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Relations\MorphPivot;
// rocXolid cms contracts
use Softworx\RocXolid\CMS\ElementableDependencies\Contracts\ElementableDependencyDataProvider;
use Softworx\RocXolid\CMS\Models\Contracts\ElementsDependenciesProvider;
use Softworx\RocXolid\CMS\Models\Contracts\ElementsMutatorsProvider;
// rocXolid cms elements contracts
use Softworx\RocXolid\CMS\Elements\Models\Contracts\Element;
use Softworx\RocXolid\CMS\Elements\Models\Contracts\Elementable;

/**
 * Elements builder (factory).
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\CMS\Elements
 * @version 1.0.0
 */
class ElementBuilder
{
    /**
     * Build element with provided pivot.
     *
     * @param \Illuminate\Database\Eloquent\Relations\MorphPivot $pivot
     * @param \Softworx\RocXolid\CMS\Elements\Models\Contracts\Elementable $parent
     * @param \Softworx\RocXolid\CMS\Models\Contracts\ElementsDependenciesProvider $depencies_provider
     * @param \Softworx\RocXolid\CMS\Models\Contracts\ElementsMutatorsProvider $mutators_provider
     * @param \Softworx\RocXolid\CMS\ElementableDependencies\Contracts\ElementableDependencyDataProvider $depencies_provider
     * @return \Softworx\RocXolid\CMS\Elements\Models\Contracts\Element
     */
    public static function buildElement(
        MorphPivot $pivot,
        Elementable $parent,
        ElementsDependenciesProvider $depencies_provider,
        ElementsMutatorsProvider $mutators_provider,
        ElementableDependencyDataProvider $depencies_data_provider
    ): Element {
        $element = $pivot->element;

        $element
            ->setParent($parent)
            ->setDependenciesProvider($depencies_provider) // propagate dependencies provider
            ->setMutatorsProvider($mutators_provider) // propagate mutators provider
            ->setDependenciesDataProvider($depencies_data_provider) // propagate dependencies data provider
            ->setPivotData(collect($pivot->attributesToArray())); // set data obtained by pivot

        return $element;
    }

    /**
     * Build element with provided type.
     *
     * @param string $type
     * @param \Softworx\RocXolid\CMS\Models\Contracts\ElementsDependenciesProvider $depencies_provider
     * @param \Softworx\RocXolid\CMS\Models\Contracts\ElementsMutatorsProvider $mutators_provider
     * @param \Softworx\RocXolid\CMS\ElementableDependencies\Contracts\ElementableDependencyDataProvider $depencies_provider
     * @param \Illuminate\Support\Collection $options
     * @return \Softworx\RocXolid\CMS\Elements\Models\Contracts\Element
     */
    public static function buildSnippetElement(
        string $type,
        ElementsDependenciesProvider $depencies_provider,
        ElementsMutatorsProvider $mutators_provider,
        ElementableDependencyDataProvider $depencies_data_provider,
        Collection $options
    ): Element {
        $element = app($type);

        $element
            ->setDependenciesProvider($depencies_provider) // propagate dependencies provider
            ->setMutatorsProvider($mutators_provider) // propagate mutators provider
            ->setDependenciesDataProvider($depencies_data_provider) // propagate dependencies data provider
            ->prepareSnippetsData($options); // prepare data for snippet

        return $element;
    }
}
