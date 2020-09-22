<?php

namespace Softworx\RocXolid\CMS\Elements\Models\Contracts;

use Illuminate\Support\Collection;

/**
 * Enables display rules to be provided.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\CMS\Elements
 * @version 1.0.0
 */
interface DisplayRulesProvider
{
    /**
     * Obtain available display rules meta data options.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getAvailableDisplayRules(): Collection;
}
