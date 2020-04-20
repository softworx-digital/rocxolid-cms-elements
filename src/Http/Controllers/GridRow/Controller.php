<?php

namespace Softworx\RocXolid\CMS\Elements\Http\Controllers\GridRow;

// rocXolid cms elements controllers
use Softworx\RocXolid\CMS\Elements\Http\Controllers\AbstractContainerElementController;
// rocXolid cms elements model viewers
use Softworx\RocXolid\CMS\Elements\Components\ModelViewers\GridRowElementViewer;
// rocXolid cms elements models
use Softworx\RocXolid\CMS\Elements\Models\GridRow;

/**
 * Grid row element controller.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\CMS\Elements
 * @version 1.0.0
 */
class Controller extends AbstractContainerElementController
{
    protected static $model_viewer_type = GridRowElementViewer::class;
}
