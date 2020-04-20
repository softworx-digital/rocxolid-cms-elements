<?php

namespace Softworx\RocXolid\CMS\Elements\Models\Contracts;

// rocXolid cms model contracts
use Softworx\RocXolid\CMS\Elements\Models\Contracts\Elementable;
// rocXolid cms elements model contracts
use Softworx\RocXolid\CMS\Elements\Models\Contracts\Element;

/**
 * Interface for model to be used as element for eg. page or document that can contain other elements.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\CMS\Elements
 * @version 1.0.0
 * @todo: define
 */
interface ContainerElement extends Element, Elementable
{

}
