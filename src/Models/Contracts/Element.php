<?php

namespace Softworx\RocXolid\CMS\Elements\Models\Contracts;

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
    public function getDocumentEditorComponentType(): string;
}
