<?php

namespace Softworx\RocXolid\CMS\Elements\Models\Traits;

use Illuminate\Support\Collection;
// rocXolid model contracts
use Softworx\RocXolid\Models\Contracts\Crudable;

/**
 * Trait for an element to enable grid layout.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\CMS\Elements
 * @version 1.0.0
 */
trait HasGridLayout
{
    /**
     * Fill grid layout configuration from request.
     *
     * @param \Illuminate\Support\Collection $data
     * @return \Softworx\RocXolid\Models\Contracts\Crudable
     */
    public function fillGridLayout(Collection $data): Crudable
    {
        $this->grid_layout = $data->has('gridLayout') ? collect($data->get('gridLayout'))->toJson() : null;

        return $this;
    }
}
