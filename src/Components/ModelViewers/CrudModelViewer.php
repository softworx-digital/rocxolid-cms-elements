<?php

namespace Softworx\RocXolid\CMS\Elements\Components\ModelViewers;

// rocXolid components
use Softworx\RocXolid\Components\ModelViewers\CrudModelViewer as RocXolidCrudModelViewer;

/**
 * CMS elements CRUD model viewer.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\CMS\Elements
 * @version 1.0.0
 */
class CrudModelViewer extends RocXolidCrudModelViewer
{
    /**
     * {@inheritDoc}
     */
    protected $view_package = 'rocXolid:cms-elements';
}
