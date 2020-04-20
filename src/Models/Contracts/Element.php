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
 * @todo: define
 */
interface Element extends Paramable, Cloneable
{
    public function getElementTypeParam(): string;

    public function getDocumentEditorComponentType(): string;

    public function setDataOnCreate(Collection $data): Element;

    public function setPivotData(Collection $pivot_data): Element;

    public function getPivotData(): Collection;
}
