<?php

namespace Softworx\RocXolid\CMS\Elements\Http\Controllers\Image;

// rocXolid cms elements controllers
use Softworx\RocXolid\CMS\Elements\Http\Controllers\AbstractElementController;
// rocXolid cms elements model viewers
use Softworx\RocXolid\CMS\Elements\Components\ModelViewers\Image as ImageModelViewer;

/**
 * Image element model controller.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\CMS\Elements
 * @version 1.0.0
 */
class Controller extends AbstractElementController
{
    protected static $model_viewer_type = ImageModelViewer::class;
}
