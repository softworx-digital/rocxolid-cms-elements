<?php

namespace Softworx\RocXolid\CMS\Elements\Http\Controllers;

// rocXolid cms elements controllers
use Softworx\RocXolid\CMS\Elements\Http\Controllers\AbstractElementController;
// rocXolid cms elements model viewers
use Softworx\RocXolid\CMS\Elements\Components\ModelViewers\ElementContainerViewer;

/**
 * CMS Elements controller for elements serving as containers.
 * Provides features to setup container elements and their containees.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\CMS\Elements
 * @version 1.0.0
 */
abstract class AbstractElementContainerController extends AbstractElementController
{
    protected static $model_viewer_type = ElementContainerViewer::class;
}
