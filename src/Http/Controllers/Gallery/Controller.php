<?php

namespace Softworx\RocXolid\CMS\Elements\Http\Controllers\Gallery;

// rocXolid cms elements controllers
use Softworx\RocXolid\CMS\Elements\Http\Controllers\AbstractElementController;
// rocXolid cms elements model viewers
use Softworx\RocXolid\CMS\Elements\Components\ModelViewers\GalleryViewer;

/**
 * Gallery element controller.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\CMS\Elements
 * @version 1.0.0
 */
class Controller extends AbstractElementController
{
    protected static $model_viewer_type = GalleryViewer::class;
}
