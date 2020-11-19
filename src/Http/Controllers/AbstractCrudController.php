<?php

namespace Softworx\RocXolid\CMS\Elements\Http\Controllers;

// rocXolid controllers
use Softworx\RocXolid\Http\Controllers\AbstractCrudController as RocXolidAbstractCrudController;
// rocXolid admin components
use Softworx\RocXolid\Admin\Components\Dashboard\Crud as CrudDashboard;

/**
 * rocXolid CMS Elements CRUD controller.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\CMS\Elements
 * @version 1.0.0
 */
abstract class AbstractCrudController extends RocXolidAbstractCrudController
{
    /**
     * {@inheritDoc}
     */
    protected static $dashboard_type = CrudDashboard::class;

    /**
     * {@inheritDoc}
     */
    protected $translation_package = 'rocXolid:cms-elements';
}
