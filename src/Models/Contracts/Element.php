<?php

namespace Softworx\RocXolid\CMS\Elements\Models\Contracts;

use Illuminate\Support\Collection;
// rocXolid contracts
use Softworx\RocXolid\Contracts\Paramable;
// rocXolid model contracts
use Softworx\RocXolid\Models\Contracts\Cloneable;

/**
 * Interface for model to be used as element for eg. page or document.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\CMS\Elements
 * @version 1.0.0
 */
interface Element extends Paramable, Cloneable
{
    /**
     * Obtain element type parameter for polymorphic mapping.
     *
     * @return string
     */
    public function getElementTypeParam(): string;

    /**
     * Obtain element type as used in document editor.
     * Mapping between internal CMS elements and document editor components.
     *
     * @return string
     */
    public function getDocumentEditorComponentType(): string;

    /**
     * Set data from pivot so it can be used on frontpage and elsewhere.
     *
     * @param \Illuminate\Support\Collection $pivot_data
     * @return Element
     */
    public function setPivotData(Collection $pivot_data): Element;

    /**
     * Retrieve pivot data.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getPivotData(): Collection;
}
