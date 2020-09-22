<?php

namespace Softworx\RocXolid\CMS\Elements\MetaData\DisplayRules\Contracts;

// rocXolid cms elementable dependency contracts
use Softworx\RocXolid\CMS\ElementableDependencies\Contracts\ElementableDependencyDataProvider;

/**
 * Enables to define display logic for elements.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\CMS\Elements
 * @version 1.0.0
 */
interface DisplayRule
{
    /**
     * Check if the element is displayed for given dependency data provider.
     *
     * @param \Softworx\RocXolid\CMS\ElementableDependencies\Contracts\ElementableDependencyDataProvider $dependency_data_provider
     * @return bool
     */
    public function preventsElementDisplay(ElementableDependencyDataProvider $dependency_data_provider): bool;
}
