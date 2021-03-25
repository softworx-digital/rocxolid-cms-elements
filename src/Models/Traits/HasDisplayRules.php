<?php

namespace Softworx\RocXolid\CMS\Elements\Models\Traits;

use Illuminate\Support\Collection;
// rocXolid cms elements meta data
use Softworx\RocXolid\CMS\Elements\MetaData\DisplayRules;

/**
 * Trait for an element to enable display rules meta data.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\CMS\Elements
 * @version 1.0.0
 */
trait HasDisplayRules
{
    /**
     * {@inheritDoc}
     */
    public function getAvailableDisplayRules(): Collection
    {
        return $this->getAvailableDisplayRulesTypes()->transform(function (string $type) {
            return app($type);
        });
    }

    /**
     * Obtain available display rule types for an element.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getAvailableDisplayRulesTypes(): Collection
    {
        return static::getConfigData(DisplayRules::class);
    }
}
