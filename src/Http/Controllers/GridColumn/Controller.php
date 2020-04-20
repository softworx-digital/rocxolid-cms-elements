<?php

namespace Softworx\RocXolid\CMS\Elements\Http\Controllers\GridColumn;

// rocXolid cms elements controllers
use Softworx\RocXolid\CMS\Elements\Http\Controllers\AbstractContainerElementController;
// rocXolid cms elements model viewers
use Softworx\RocXolid\CMS\Elements\Components\ModelViewers\GridColumnElementViewer;
// rocXolid cms elements models
use Softworx\RocXolid\CMS\Elements\Models\GridColumn;

/**
 * Grid column element controller.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\CMS\Elements
 * @version 1.0.0
 */
class Controller extends AbstractContainerElementController
{
    protected static $model_viewer_type = GridColumnElementViewer::class;
}
