<?php

namespace Softworx\RocXolid\CMS\Elements\Components\ModelViewers;

use Softworx\RocXolid\Components\ModelViewers\CrudModelViewer as RocXolidCrudModelViewer;
use Softworx\RocXolid\CMS\Rendering\Contracts\Themeable;
use Softworx\RocXolid\CMS\Rendering\Traits\CanBeThemed;

/**
 *
 */
class CrudModelViewer extends RocXolidCrudModelViewer implements Themeable
{
    use CanBeThemed;

    protected $view_package = 'rocXolid:cms-elements';
}
